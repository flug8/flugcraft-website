<div data-control="toolbar">
    <a
        href="javascript:;"
        class="btn btn-primary oc-icon-refresh"
        data-updatelist-check
    >
        <?= e(__('Check For Updates')) ?>
    </a>
    <a
        href="<?= Backend::url('system/market') ?>"
        class="btn btn-default oc-icon-plus">
        <?= e(__('Install Packages')) ?>
    </a>
    <a
        href="<?= Backend::url('cms/themes') ?>"
        class="btn btn-default oc-icon-image">
        <?= e(__('Manage Themes')) ?>
    </a>
    <a
        href="<?= Backend::url('system/updates/manage') ?>"
        class="btn btn-default oc-icon-puzzle-piece">
        <?= e(__('Manage Plugins')) ?>
    </a>
</div>
