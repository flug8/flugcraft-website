<?php
    $activeValue = $scope->scopeValue !== null ? $scope->value : $scope->default;
?>
<div
    class="filter-scope form-check"
    data-scope-name="<?= $scope->scopeName ?>">
    <input class="form-check-input" type="checkbox" id="<?= $scope->getId() ?>" <?= $activeValue ? 'checked' : '' ?> />
    <label class="form-check-label" for="<?= $scope->getId() ?>"><?= e(trans($scope->label)) ?></label>
</div>
