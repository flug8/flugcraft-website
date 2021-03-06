<?php
    $sortModes = [
        Media\Classes\MediaLibrary::SORT_BY_TITLE => trans('backend::lang.media.title'),
        Media\Classes\MediaLibrary::SORT_BY_SIZE => trans('backend::lang.media.size'),
        Media\Classes\MediaLibrary::SORT_BY_MODIFIED => trans('backend::lang.media.last_modified')
    ];

    $sortDirections = [
        Media\Classes\MediaLibrary::SORT_DIRECTION_ASC => trans('backend::lang.media.direction_asc'),
        Media\Classes\MediaLibrary::SORT_DIRECTION_DESC => trans('backend::lang.media.direction_desc')
    ];
?>

<div class="sidebar-group">
    <h3 class="section"><?= e(trans('backend::lang.media.order_by')) ?></h3>

    <select
        name="sorting"
        class="form-control custom-select select-no-search"
        data-control="sorting"
        data-sort="by">
        <?php foreach ($sortModes as $code=>$title): ?>
            <option
                <?= $code == $sortBy ? 'selected="selected"' : '' ?>
                value="<?= $code ?>"
            ><?= e($title) ?></option>
        <?php endforeach ?>
    </select>
</div>

<div class="sidebar-group">
    <h3 class="section"><?= e(trans('backend::lang.media.direction')) ?></h3>

    <select
        name="sorting"
        class="form-control custom-select select-no-search"
        data-control="sorting"
        data-sort="direction">
        <?php foreach ($sortDirections as $code=>$title): ?>
            <option
                <?= $code == $sortDirection ? 'selected="selected"' : '' ?>
                value="<?= $code ?>"
            ><?= e($title) ?></option>
        <?php endforeach ?>
    </select>
</div>
