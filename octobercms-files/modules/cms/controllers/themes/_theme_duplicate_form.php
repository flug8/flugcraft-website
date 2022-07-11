<?= Form::ajax('onDuplicateTheme', [
    'id' => 'themeDuplicateForm',
    'data-popup-load-indicator' => true,
]) ?>

    <input type="hidden" name="theme" value="<?= $themeDir ?>" />

    <div class="modal-header">
        <h4 class="modal-title"><?= e(trans('cms::lang.theme.duplicate_title')) ?>: <?= $themeDir ?></h4>
        <button type="button" class="btn-close" data-dismiss="popup"></button>
    </div>

    <?php if (!$this->fatalError): ?>

        <div class="modal-body">

            <div class="form-group text-field span-full">
                <label class="form-label" for="Form-ThemeDuplicate-newDirName">
                    <?= e(trans('cms::lang.theme.new_directory_name_label')) ?>
                </label>
                <input
                    type="text"
                    name="new_dir_name"
                    id="Form-ThemeDuplicate-newDirName"
                    value="<?= $themeDir ?>"
                    placeholder=""
                    class="form-control"
                    autocomplete="off"
                    maxlength="255" />

                <p class="form-text">
                    <?= e(trans('cms::lang.theme.new_directory_name_comment')) ?>
                </p>
            </div>

        </div>
        <div class="modal-footer">
            <button
                type="submit"
                class="btn btn-success">
                <?= e(trans('cms::lang.theme.duplicate_button')) ?>
            </button>

            <button
                type="button"
                class="btn btn-default"
                data-dismiss="popup">
                <?= e(trans('backend::lang.form.cancel')) ?>
            </button>
        </div>

    <?php else: ?>

        <div class="modal-body">
            <p class="flash-message static error"><?= e(trans($this->fatalError)) ?></p>
        </div>
        <div class="modal-footer">
            <button
                type="button"
                class="btn btn-default"
                data-dismiss="popup">
                <?= e(trans('backend::lang.form.close')) ?>
            </button>
        </div>

    <?php endif ?>

    <script>
        setTimeout(
            function(){ $('#themeDuplicateForm input.form-control:first').focus() },
            310
        )
    </script>

<?= Form::close() ?>
