<?php namespace Tailor\Components;

use Tailor\Classes\ComponentVariable;
use Tailor\Classes\BlueprintIndexer;
use Tailor\Models\EntryRecord;
use Cms\Classes\ComponentBase;
use Tailor\Models\PreviewToken;

/**
 * SectionComponent displays a list of records.
 */
class SectionComponent extends ComponentBase
{
    /**
     * componentDetails
     */
    public function componentDetails()
    {
        return [
            'name' => 'Section',
            'description' => 'Defines a website section with a supporting entry.'
        ];
    }

    /**
     * defineProperties
     */
    public function defineProperties()
    {
        return [
            'handle' => [
                'title' => 'Record Handle',
                'type' => 'dropdown',
                'showExternalParam' => false
            ],
            'entrySlug' => [
                'title' => 'Entry Slug',
                'type' => 'string',
                'description' => 'Specify a slug to make this a primary page for the record.'
            ],
            'entryDefault' => [
                'title' => 'Default View',
                'type' => 'checkbox',
                'description' => 'Used as default entry point when previewing the record.',
            ],
            'fullSlug' => [
                'title' => 'Full Slug',
                'type' => 'checkbox',
                'description' => 'Use the full slug when looking up the record.',
            ],
        ];
    }

    /**
     * makePrimaryAccessor returns the PHP object variable for the Twig view layer.
     */
    public function makePrimaryAccessor()
    {
        return new ComponentVariable($this);
    }

    /**
     * onRun
     */
    public function onRun()
    {
        if ($token = get('_preview_token')) {
            PreviewToken::checkTokenForCurrentUrl($token);
        }
    }

    /**
     * getHandleOptions
     */
    public function getHandleOptions()
    {
        $blueprints = BlueprintIndexer::instance()->listSections();

        $result = [];
        foreach ($blueprints as $bp) {
            $result[$bp->handle] = $bp->name . ' ('.$bp->handle.')';
        }

        return $result;
    }

    /**
     * getPrimaryRecord
     */
    public function getPrimaryRecord()
    {
        $query = $this->getPrimaryRecordQuery();

        // Using entry point
        if ($slug = $this->property('entrySlug')) {
            if ($model = $this->getPreviewModel($query)) {
                return $model;
            }

            if ($this->property('fullSlug')) {
                return $query->where('fullslug', $slug)->first();
            }

            return $query->where('slug', $slug)->first();
        }

        // Single section is the same as an entry point
        if ($query->getModel()->isEntrySingle()) {
            if ($model = $this->getPreviewModel($query)) {
                return $model;
            }

            return $query->first();
        }

        // Assuming multiple records are wanted
        if ($query->getModel()->isEntryStructure()) {
            return $query->getNested();
        }

        return $query->get();
    }

    /**
     * getPrimaryRecordQuery
     */
    public function getPrimaryRecordQuery()
    {
        $handle = $this->property('handle');

        $model = EntryRecord::inSection($handle)->applyVisibleFrontend();

        return $model;
    }

    /**
     * getPreviewModel
     */
    protected function getPreviewModel($query)
    {
        if (
            ($token = PreviewToken::getEnabledToken()) &&
            ($previewId = $token->getRouteParam('id'))
        ) {
            return $query->withoutGlobalScopes()->find($previewId);
        }
    }
}
