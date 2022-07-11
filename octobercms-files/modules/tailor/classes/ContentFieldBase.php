<?php namespace Tailor\Classes;

use October\Contracts\Element\ListElement;
use October\Contracts\Element\FormElement;
use October\Contracts\Element\FilterElement;
use October\Rain\Element\Form\FieldDefinition;

/**
 * ContentFieldBase class for content fields
 *
 * @method ContentFieldBase column(array $config) column configuration
 * @method ContentFieldBase scope(array $config) scope configuration
 *
 * @package october\tailor
 * @author Alexey Bobkov, Samuel Georges
 */
abstract class ContentFieldBase extends FieldDefinition
{
    /**
     * defineConfig for the field
     */
    public function defineConfig(array $config)
    {
    }

    /**
     * validateConfig for the field
     */
    public function validateConfig()
    {
    }

    /**
     * extendModelObject
     */
    public function extendModelObject($model)
    {
    }

    /**
     * extendModelValidation
     */
    public function extendModelValidation($model)
    {
    }

    /**
     * extendDatabaseTable
     */
    public function extendDatabaseTable($table)
    {
    }

    /**
     * defineListColumn
     */
    public function defineListColumn(ListElement $list, $context = null)
    {
    }

    /**
     * defineFilterScope
     */
    public function defineFilterScope(FilterElement $filter, $context = null)
    {
    }

    /**
     * defineFormField
     */
    public function defineFormField(FormElement $form, $context = null)
    {
    }

    /**
     * extendModel
     */
    public function extendModel($model)
    {
        $this->extendModelObject($model);
        $this->extendModelValidation($model);
    }

    /**
     * evalConfig from an array and apply them to the object
     */
    public function evalConfig(array $config)
    {
        $this->defineConfig($config);
    }

    /**
     * validate
     */
    public function validate()
    {
        $this->validateConfig();
    }
}
