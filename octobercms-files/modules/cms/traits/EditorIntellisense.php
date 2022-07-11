<?php namespace Cms\Traits;

/**
 * EditorIntellisense provides data for the front-end CMS IntelliSense feature.
 */
trait EditorIntellisense
{
    /**
     * intellisenseLoadOctoberTags
     */
    protected function intellisenseLoadOctoberTags()
    {
        return $this->loadAndLocalizeJsonFile(__DIR__.'/editorintellisense/octobertags.json');
    }

    /**
     * intellisenseLoadTwigFilters
     */
    protected function intellisenseLoadTwigFilters()
    {
        return $this->loadAndLocalizeJsonFile(__DIR__.'/editorintellisense/twigfilters.json');
    }
}
