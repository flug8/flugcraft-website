<?php namespace Flugcraft\Importexport;

use Backend;
use System\Classes\PluginBase;

/**
 * Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Importexport',
            'description' => 'No description provided yet...',
            'author'      => 'Flugcraft',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Flugcraft\Importexport\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any backend permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'flugcraft.importexport.some_permission' => [
                'tab' => 'Importexport',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers backend navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'importexport' => [
                'label'       => 'Importexport',
                'url'         => Backend::url('flugcraft/importexport/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['flugcraft.importexport.*'],
                'order'       => 500,
            ],
        ];
    }
}
