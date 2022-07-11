<?php namespace Tailor\Models;

use Model;
use October\Contracts\Element\ListElement;
use October\Contracts\Element\FormElement;
use October\Contracts\Element\FilterElement;
use Tailor\Classes\Scopes\EntryRecordScope;
use Tailor\Classes\BlueprintIndexer;
use ApplicationException;

/**
 * EntryRecord model for content
 *
 * @package october\tailor
 * @author Alexey Bobkov, Samuel Georges
 */
class EntryRecord extends Model
{
    use \Tailor\Traits\DraftableModel;
    use \Tailor\Traits\NestedTreeModel;
    use \Tailor\Traits\VersionableModel;
    use \Tailor\Traits\DeferredContentModel;
    use \Tailor\Models\EntryRecord\HasStatusScopes;
    use \Tailor\Models\EntryRecord\HasBlueprintTypes;
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var array implement behaviors in this model
     */
    public $implement = [
        \Tailor\Behaviors\ContentTableModel::class
    ];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'title' => 'required'
    ];

    /**
     * @var string contentGroupFrom attribute
     */
    public $contentGroupFrom = 'content_group';

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = ['published_at', 'published_at_date', 'expired_at'];

    /**
     * defineListColumns
     */
    public function defineListColumns(ListElement $host)
    {
        $host->defineColumn('id', 'ID')->invisible();
        $host->defineColumn('title', 'Title')->searchable(true);
        $host->defineColumn('slug', 'Slug')->searchable(true)->invisible();

        if ($this->isEntryStructure()) {
            $host->defineColumn('fullslug', 'Full Slug')->searchable(false)->invisible();
        }

        $host->defineColumn('entry_type_name', 'Entry Type')->shortLabel('Type')->invisible()->sortable(false);

        $this->getContentFieldsetDefinition()->defineAllListColumns($host);

        $host->defineColumn('published_at_date', 'Published Date')->shortLabel('Published')->displayAs('date')->invisible();
        $host->defineColumn('status_code', 'Status')->shortLabel('')->displayAs('selectable')->sortable(false)->align('right');
    }

    /**
     * defineFilterScopes
     */
    public function defineFilterScopes(FilterElement $host)
    {
        $host->defineScope('status_code', 'Status')->displayAs('dropdown')->options('getStatusCodeOptions')->emptyOption('All Entries')->modelScope('applyStatusFromFilter');

        $this->getContentFieldsetDefinition()->defineAllFilterScopes($host);

        $host->defineScope('published_at_date', 'Published Date')->displayAs('date');
    }

    /**
     * defineFormFields
     */
    public function defineFormFields(FormElement $host)
    {
        $entryName = $this->getContentFieldsetDefinition()->name ?? '';

        $host->addFormField('title', 'Title')->autoFocus()->cssClass('primary-title-field')->placeholder("New {$entryName} Entry");
    }

    /**
     * definePrimaryFormFields
     */
    public function definePrimaryFormFields(FormElement $host)
    {
        $this->getFieldsetDefinition()->defineAllFormFields($host);
    }

    /**
     * defineSecondaryFormFields
     */
    public function defineSecondaryFormFields(FormElement $host)
    {
        $host->addFormField('slug', 'Slug')->preset(['field' => 'title', 'type' => 'slug']);
        $host->addFormField('is_enabled', 'Enabled')->displayAs('switch');
        $host->addFormField('published_at', 'Publish Date')->displayAs('datepicker')->defaultTimeMidnight();
        $host->addFormField('expired_at', 'Expiry Date')->displayAs('datepicker')->defaultTimeMidnight();
        $host->addFormField('parent_id', 'Parent')->displayAs('dropdown');
    }

    /**
     * afterBoot
     */
    public function afterBoot()
    {
        static::addGlobalScope(new EntryRecordScope);
    }

    /**
     * beforeUpdate
     */
    public function beforeUpdate()
    {
        $this->setPublishingDates($this->published_at ?: $this->created_at);
    }

    /**
     * beforeCreate
     */
    public function beforeCreate()
    {
        $this->setPublishingDates($this->freshTimestamp());
    }

    /**
     * setPublishingDates
     */
    protected function setPublishingDates($useDate)
    {
        if ($this->isEntryStream()) {
            $this->published_at_day = $useDate->format('d');
            $this->published_at_month = $useDate->format('m');
            $this->published_at_year = $useDate->format('Y');
        }

        $this->published_at_date = $useDate;
    }

    /**
     * inSection
     */
    public static function inSection($handle)
    {
        $blueprint = BlueprintIndexer::instance()->findSectionByHandle($handle);
        if (!$blueprint) {
            throw new ApplicationException("Section handle [{$handle}] not found");
        }

        return static::inSectionUuid($blueprint->uuid);
    }

    /**
     * inSectionUuid
     */
    public static function inSectionUuid($uuid)
    {
        $instance = new static;

        $instance->extendWithBlueprint($uuid);

        return $instance;
    }

    /**
     * scopeApplyVisibleFrontend adds visibility to the front end with support
     * for preview tokens
     */
    public function scopeApplyVisibleFrontend($query)
    {
        if (PreviewToken::isTokenEnabled()) {
            return $query;
        }

        return $query->where('is_enabled', true);
    }

    /**
     * getBlueprintAttribute
     */
    public function getBlueprintAttribute()
    {
        return $this->getBlueprintDefinition();
    }

    /**
     * getEntryTypeNameAttribute
     */
    public function getEntryTypeNameAttribute()
    {
        return BlueprintIndexer::instance()
            ->findFieldset($this->blueprint_uuid, $this->content_group)
            ->name ?? '';
        ;
    }

    /**
     * getEntryTypeAttribute
     */
    public function getEntryTypeAttribute()
    {
        return BlueprintIndexer::instance()
            ->findFieldset($this->blueprint_uuid, $this->content_group)
            ->handle ?? '';
        ;
    }

    /**
     * setDefaultContentGroup populate the default content group for new records
     */
    public function setDefaultContentGroup()
    {
        $defaultGroup = array_keys($this->getContentGroupOptions())[0] ?? null;

        if ($defaultGroup) {
            $this->setBlueprintGroup($defaultGroup);
        }
    }

    /**
     * getContentGroupOptions
     */
    public function getContentGroupOptions()
    {
        return $this->getBlueprintDefinition()->getEntryTypeOptions();
    }

    /**
     * getParentIdOptions
     */
    public function getParentIdOptions()
    {
        return $this->getParentIdOptionsFromQuery($this->withSavedDrafts());
    }

    /**
     * findSingleForSection
     */
    public static function findSingleForSection($handle): EntryRecord
    {
        $blueprint = BlueprintIndexer::instance()->findSectionByHandle($handle);
        if (!$blueprint) {
            throw new ApplicationException("Section handle [{$handle}] not found");
        }

        return static::findSingleForSectionUuid($blueprint->uuid);
    }

    /**
     * findSingleForSectionUuid
     */
    public static function findSingleForSectionUuid($uuid): EntryRecord
    {
        // Find existing record
        $record = static::inSectionUuid($uuid)->first();
        if ($record) {
            return $record;
        }

        // Create new record
        $entry = new static;
        $entry->extendWithBlueprint($uuid);
        $entry->forceSave();

        return $entry;
    }

    /**
     * useNestedTreeStructure only for primary records
     */
    public function useNestedTreeStructure(): bool
    {
        return $this->isEntryStructure() && !$this->primary_id;
    }

    /**
     * newNestedTreeQuery creates a new query for nested sets
     */
    protected function newNestedTreeQuery()
    {
        return $this->newQuery()->withSavedDrafts();
    }

    /**
     * getVersionableTransferAttributes
     */
    protected function getVersionableTransferAttributes()
    {
        return $this->getFieldsetColumnNames();
    }

    /**
     * getMorphClass adds dynamic table support
     * @return string
     */
    public function getMorphClass()
    {
        return parent::getMorphClass() . '@' . $this->getTable();
    }
}
