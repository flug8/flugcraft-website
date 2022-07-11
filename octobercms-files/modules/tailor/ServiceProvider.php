<?php namespace Tailor;

use Event;
use Backend\Models\UserRole;
use Tailor\Classes\BlueprintIndexer;
use October\Rain\Support\ModuleServiceProvider;

/**
 * ServiceProvider for Tailor module
 */
class ServiceProvider extends ModuleServiceProvider
{
    /**
     * register the service provider
     */
    public function register()
    {
        parent::register('tailor');

        $this->registerEditorEvents();
        $this->registerConsole();

        $this->extendMigrateCommand();
        $this->extendDeferredBindingForContent();
    }

    /**
     * boot the module events
     */
    public function boot()
    {
        parent::boot('tailor');
    }

    /**
     * registerComponents
     */
    public function registerComponents()
    {
        return [
           \Tailor\Components\GlobalComponent::class => 'global',
           \Tailor\Components\SectionComponent::class => 'section',
           \Tailor\Components\CollectionComponent::class => 'collection',
           \Cms\Components\Resources::class => 'resources'
        ];
    }

    /**
     * registerNavigation
     */
    public function registerNavigation()
    {
        return BlueprintIndexer::instance()->getNavigationMainMenu() +
            BlueprintIndexer::instance()->getNavigationContentMainMenu();
    }

    /**
     * registerSettings
     */
    public function registerSettings()
    {
        return BlueprintIndexer::instance()->getNavigationSettingsMenu();
    }

    /**
     * registerPermissions
     */
    public function registerPermissions()
    {
        return [
            // Editor
            'editor.tailor_blueprints' => [
                'label' => 'Manage Blueprints',
                'tab' => 'Editor',
                'roles' => UserRole::CODE_DEVELOPER,
                'order' => 100
            ]
        ] + BlueprintIndexer::instance()->getPermissionDefinitions();
    }

    /**
     * registerConsole
     */
    protected function registerConsole()
    {
        $this->registerConsoleCommand('tailor.refresh', \Tailor\Console\TailorRefresh::class);
        $this->registerConsoleCommand('tailor.migrate', \Tailor\Console\TailorMigrate::class);
    }

    /**
     * registerContentFields
     */
    public function registerContentFields()
    {
        return [
            \Tailor\ContentFields\MixinField::class => 'mixin',
            \Tailor\ContentFields\EntriesField::class => 'entries',
            \Tailor\ContentFields\RepeaterField::class => 'repeater',
            \Tailor\ContentFields\RichEditorField::class => 'richeditor',
            \Tailor\ContentFields\MarkdownField::class => 'markdown',
            \Tailor\ContentFields\FileUploadField::class => 'fileupload',
            \Tailor\ContentFields\MediaFinderField::class => 'mediafinder',
            \Tailor\ContentFields\DataTableField::class => 'datatable',
        ];
    }

    /**
     * registerEditorEvents handles Editor events
     */
    protected function registerEditorEvents()
    {
        Event::listen('editor.extension.register', function () {
            return \Tailor\Classes\EditorExtension::class;
        });
    }

    /**
     * extendMigrateCommand to migrate blueprints
     */
    public function extendMigrateCommand()
    {
        Event::listen('system.updater.migrate', function ($updateManager) {
            BlueprintIndexer::instance()
                ->setNotesOutput($updateManager->getNotesOutput())->migrate();
        });
    }

    /**
     * extendDeferredBindingForContent
     */
    protected function extendDeferredBindingForContent()
    {
        Event::listen('deferredBinding.newMasterInstance', function($model, $masterObject) {
            if (
                $masterObject instanceof \Tailor\Models\EntryRecord ||
                $masterObject instanceof \Tailor\Models\RepeaterItem ||
                $masterObject instanceof \Tailor\Models\GlobalRecord
            ) {
                $masterObject->extendDeferredContentModel($model);
            }
        });
    }
}
