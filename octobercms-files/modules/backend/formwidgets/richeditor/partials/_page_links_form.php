<?= Form::open(['id' => 'pageLinksForm']) ?>
    <div class="modal-header">
        <h4 class="modal-title"><?= e(trans('backend::lang.pagelist.page_link')) ?></h4>
        <button type="button" class="btn-close" data-dismiss="popup"></button>
    </div>
    <div class="modal-body">

        <div class="form-group">
            <select name="pagelink" class="form-control custom-select" id="pageLink">
                <?php foreach ($links as $link): ?>
                    <option value="<?= array_get($link, 'url') ?>"><?= array_get($link, 'name') ?></option>
                <?php endforeach ?>
            </select>
        </div>

    </div>

    <div class="modal-footer">
        <button
            type="button"
            class="btn btn-primary"
            data-dismiss="popup"
            onclick="richeditorPageLinksSelectPage($('#pageLinksForm'))">
            <?= e(trans('backend::lang.form.select')) ?>
        </button>
        <button
            type="button"
            class="btn btn-default"
            data-dismiss="popup">
            <?= e(trans('backend::lang.form.cancel')) ?>
        </button>
    </div>
<?= Form::close() ?>
