<?php namespace Tailor\Classes;

use App;
use Str;
use System;
use Tailor\Classes\Fieldset;
use Tailor\Classes\BlueprintIndexer;
use Tailor\Classes\ContentFieldBase;
use Tailor\ContentFields\MixinField;
use Tailor\ContentFields\GenericField;
use Tailor\ContentFields\FallbackField;
use Tailor\Classes\Blueprint\MixinBlueprint;
use System\Classes\PluginManager;

/**
 * FieldManager
 *
 * @method static FieldManager instance()
 *
 * @package october\tailor
 * @author Alexey Bobkov, Samuel Georges
 */
class FieldManager
{
    use \October\Rain\Support\Traits\Singleton;

    /**
     * @var array customFields stored in the form of ['FieldClass' => $fieldInfo].
     */
    protected $customFields;

    /**
     * @var array customFieldCallbacks cache of form widget registration callbacks.
     */
    protected $customFieldCallbacks = [];

    /**
     * @var array customFieldHints keyed by their code/alias.
     */
    protected $customFieldHints;

    /**
     * @var System\Classes\PluginManager
     */
    protected $pluginManager;

    /**
     * init initializes this singleton.
     */
    protected function init()
    {
        $this->pluginManager = PluginManager::instance();
    }

    /**
     * makeField makes a custom field or returns a fallback one.
     */
    public function makeField(string $name, $config = []): ContentFieldBase
    {
        $type = $config['type'] ?? null;
        $field = $this->makeFallbackField($name, $type);
        if (!$type) {
            return $field;
        }

        $className = $this->getCustomFieldClassName($type);
        if ($className && class_exists($className)) {
            $field = new $className(['fieldName' => $name]);
        }

        return $field;
    }

    /**
     * makeFallbackField
     */
    protected function makeFallbackField($name, $type): ContentFieldBase
    {
        $genericTypes = [
            'balloon-selector',
            'checkbox',
            'checkboxlist',
            'dropdown',
            'email',
            'number',
            'password',
            'radio',
            'switch',
            'text',
            'textarea',
        ];

        if (in_array($type, $genericTypes)) {
            return new GenericField(['fieldName' => $name]);
        }

        return new FallbackField(['fieldName' => $name]);
    }

    /**
     * listCustomFields returns a list of registered content fields.
     */
    public function listCustomFields(): array
    {
        if ($this->customFields !== null) {
            return $this->customFields;
        }

        $this->customFields = [];

        // Load external fields
        foreach ($this->customFieldCallbacks as $callback) {
            $callback($this);
        }

        // Load module fields
        foreach (System::listModules() as $module) {
            if ($provider = App::getProvider($module . '\\ServiceProvider')) {
                $this->loadCustomFieldsFromArray($provider->registerContentFields());
            }
        }

        // Load plugin fields
        $plugins = $this->pluginManager->getPlugins();
        foreach ($plugins as $plugin) {
            $this->loadCustomFieldsFromArray($plugin->registerContentFields());
        }

        // Load app items
        if ($app = App::getProvider(\App\Provider::class)) {
            $this->loadCustomFieldsFromArray($app->registerContentFields());
        }

        return $this->customFields;
    }

    /**
     * loadExtensionsFromArray helper
     */
    protected function loadCustomFieldsFromArray($fields)
    {
        if (!is_array($fields)) {
            return;
        }

        foreach ($fields as $className => $fieldInfo) {
            $this->registerCustomField($className, $fieldInfo);
        }
    }

    /**
     * registerCustomField registers a form field.
     */
    public function registerCustomField(string $className, $fieldInfo = null): void
    {
        if (!is_array($fieldInfo)) {
            $fieldInfo = ['code' => $fieldInfo];
        }

        $fieldCode = $fieldInfo['code'] ?? null;

        if (!$fieldCode) {
            $fieldCode = Str::getClassId($className);
        }

        $this->customFields[$className] = $fieldInfo;
        $this->customFieldHints[$fieldCode] = $className;
    }

    /**
     * registerCustomFields manually registers form widget for consideration. Usage:
     *
     *     FieldManager::registerCustomFields(function ($manager) {
     *         $manager->registerCustomField(\Tailor\ContentFields\Entries::class, 'entries');
     *     });
     *
     */
    public function registerCustomFields(callable $definitions)
    {
        $this->customFieldCallbacks[] = $definitions;
    }

    /**
     * resolveCustomField returns a class name from a custom field code/alias
     */
    public function resolveCustomField(string $name): string
    {
        return $this->getCustomFieldClassName($name) ?: $name;
    }

    /**
     * resolveCustomField returns a class name from a custom field code/alias
     */
    protected function getCustomFieldClassName(string $name): ?string
    {
        if ($this->customFields === null) {
            $this->listCustomFields();
        }

        $hints = $this->customFieldHints;

        if (isset($hints[$name])) {
            return $hints[$name];
        }

        $_name = Str::normalizeClassName($name);
        if (isset($this->customFields[$_name])) {
            return $_name;
        }

        return null;
    }

    //
    // Fieldsets
    //

    /**
     * makeFieldset will add fields to the fieldset based on supplied config
     */
    public function makeFieldset($config = []): Fieldset
    {
        $fieldset = new Fieldset($config);
        $manager = BlueprintIndexer::instance();
        $fields = $config['fields'] ?? [];

        foreach ($fields as $fieldName => $fieldConfig) {
            $field = $this->makeField($fieldName, $fieldConfig);
            if (is_array($fieldConfig)) {
                $field->useConfig($fieldConfig);
            }

            if ($field instanceof MixinField) {
                if (($mixinUuid = $manager->hasMixin($field->source)) && ($mixin = $manager->findMixin($mixinUuid))) {
                    $this->populateFieldsetFromMixin($fieldset, $field, $mixin);
                }
            }
            else {
                $fieldset->addField($fieldName, $field);
            }
        }

        return $fieldset;
    }

    /**
     * populateFieldsetFromMixin merges the parent field with the referenced
     * fields then mixes them in to the collection
     */
    protected function populateFieldsetFromMixin(Fieldset $fieldset, ContentFieldBase $parentField, MixinBlueprint $mixin): void
    {
        $manager = BlueprintIndexer::instance();
        $fields = $mixin->fields ?? [];

        foreach ($fields as $fieldName => $fieldConfig) {
            $parentConfig = array_except($parentField->config, ['fieldName', 'valueFrom', 'type']);
            $field = $this->makeField($fieldName, $fieldConfig);
            $field->useConfig($fieldConfig + $parentConfig);

            if ($field instanceof MixinField) {
                if (($mixinUuid = $manager->hasMixin($field->source)) && ($mixin = $manager->findMixin($mixinUuid))) {
                    $this->populateFieldsetFromMixin($fieldset, $field, $mixin);
                }
            }
            else {
                $fieldset->addField($fieldName, $field);
            }
        }
    }
}
