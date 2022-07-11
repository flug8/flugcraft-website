<?php namespace Tailor\Components;

use Tailor\Classes\ComponentVariable;
use Tailor\Classes\BlueprintIndexer;
use Tailor\Models\EntryRecord;
use Cms\Classes\ComponentBase;
use SystemException;

/**
 * CollectionComponent displays a single record.
 */
class CollectionComponent extends ComponentBase
{
    /**
     * componentDetails
     */
    public function componentDetails()
    {
        return [
            'name' => 'Collection',
            'description' => 'Displays a collection of entries.'
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
            'recordsPerPage' => [
                'title' => 'Records Per Page',
                'description' => 'Number of records to display on a single page. Leave empty to disable pagination.',
                'type' => 'string',
                'validationPattern' => '^[0-9]*$',
                'validationMessage' => 'Invalid format of the records per page value. The value should be a number.',
                'group' => 'Pagination'
            ],
            'pageNumber' => [
                'title' => 'Page Number',
                'description' => 'This value is used to determine what page the user is on.',
                'type' => 'string',
                'group' => 'Pagination'
            ],
            'sortColumn' => [
                'title' => 'Sort by Column',
                'description' => 'Model column the records should be ordered by',
                'type' => 'autocomplete',
                'group' => 'Sorting',
                'showExternalParam' => false
            ],
            'sortDirection' => [
                'title' => 'Direction',
                'type' => 'dropdown',
                'showExternalParam' => false,
                'group' => 'Sorting',
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending'
                ]
            ]
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

        if ($slug = $this->property('entrySlug')) {
            return $query->where('slug', $slug)->first();
        }

        return $query->get();
    }

    /**
     * getPrimaryRecordQuery
     */
    public function getPrimaryRecordQuery()
    {
        $handle = $this->property('handle');

        $model = EntryRecord::inSection($handle)->where('is_enabled', true);

        return $model;
    }
}
