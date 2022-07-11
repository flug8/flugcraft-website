<div class="facet-item">
    <input
        name="Filter[min]"
        type="number"
        value="<?= e($scope->min ?: $scope->defaultMin) ?>"
        class="form-control form-control-sm popup-allow-focus w-90"
        autocomplete="off" />
</div>
<div class="facet-item">
    <span>and</span>
</div>
<div class="facet-item">
    <input
        name="Filter[max]"
        type="number"
        value="<?= e($scope->max ?: $scope->defaultMax) ?>"
        class="form-control form-control-sm popup-allow-focus w-90"
        autocomplete="off" />
</div>
