<?php namespace Tailor\VueComponents;

use Backend\Classes\VueComponentBase;

/**
 * Tailor entry publishing controls Vue component.
 *
 * @package october\backend
 * @author Alexey Bobkov, Samuel Georges
 */
class PublishingControls extends VueComponentBase
{
    /**
     * Adds dependency assets required for the component.
     * This method is called before the component's default resources are loaded.
     * Use $this->addJs() and $this->addCss() to register new assets to include
     * on the page.
     * @return void
     */
    protected function loadDependencyAssets()
    {
        $this->addJsBundle('js/domtools.js', 'core');
    }

    protected $require = [
        \Backend\VueComponents\Popover::class
    ];
}
