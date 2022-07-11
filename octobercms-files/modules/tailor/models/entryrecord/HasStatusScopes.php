<?php namespace Tailor\Models\EntryRecord;

use Carbon\Carbon;
use Tailor\Classes\Scopes\DraftableScope;

/**
 * HasStatusScopes
 *
 * @package october\tailor
 * @author Alexey Bobkov, Samuel Georges
 */
trait HasStatusScopes
{
    /**
     * getStatusCodeAttribute
     */
    public function getStatusCodeAttribute()
    {
        if ($this->useDrafts() && $this->isDraftStatus()) {
            return 'draft';
        }

        if (!$this->is_enabled) {
            return 'hidden';
        }

        if ($this->published_at || $this->expired_at) {
            $now = Carbon::now();

            if ($this->published_at && $now < $this->published_at) {
                return 'scheduled';
            }

            if ($this->expired_at && $now > $this->expired_at) {
                return 'expired';
            }
        }

        return 'published';
    }

    /**
     * getStatusNameOptions
     */
    public function getStatusCodeOptions()
    {
        return [
            'published' => ['Published', '#85CB43'],
            'expired' => ['Expired', '#c0392b'],
            'scheduled' => ['Scheduled', '#6a6cf7'],
            'hidden' => ['Hidden', '#bdc3c7'],
            'draft' => ['Draft', '#e67e21'],
            'deleted' => ['Deleted', '#536061']
        ];
    }

    /**
     * scopeApplyStatusFromFilter
     */
    public function scopeApplyStatusFromFilter($query, $scope)
    {
        if ($scope->value === 'published') {
            return $query->applyPublishedStatus();
        }

        if ($scope->value === 'expired') {
            return $query->applyExpiredStatus();
        }

        if ($scope->value === 'scheduled') {
            return $query->applyScheduledStatus();
        }

        if ($scope->value === 'draft') {
            return $query->applyDraftStatus();
        }

        if ($scope->value === 'hidden') {
            return $query->applyHiddenStatus();
        }

        return $query;
    }

    /**
     * scopeApplyPublished
     */
    public function scopeApplyPublishedStatus($query)
    {
        $now = Carbon::now();

        return $query->where('is_enabled', 1)
            ->where(function($q) use ($now) {
                $q->whereNull('published_at');
                $q->orWhere('published_at', '<', $now);
            })
            ->where(function($q) use ($now) {
                $q->whereNull('expired_at');
                $q->orWhere('expired_at', '>', $now);
            })
        ;
    }

    /**
     * scopeApplyPublished
     */
    public function scopeApplyScheduledStatus($query)
    {
        $now = Carbon::now();

        return $query->where('is_enabled', 1)
            ->where('published_at', '>', $now)
        ;
    }

    /**
     * scopeApplyPublished
     */
    public function scopeApplyExpiredStatus($query)
    {
        $now = Carbon::now();

        return $query->where('is_enabled', 1)
            ->where('expired_at', '<', $now)
        ;
    }

    /**
     * scopeApplyHiddenStatus
     */
    public function scopeApplyHiddenStatus($query)
    {
        return $query->where('is_enabled', '<>', 1)
            ->where('draft_mode', DraftableScope::MODE_PUBLISHED);
    }

    /**
     * scopeApplyPublished
     */
    public function scopeApplyDraftStatus($query)
    {
        return $query->where('draft_mode', '<>', DraftableScope::MODE_PUBLISHED);
    }
}
