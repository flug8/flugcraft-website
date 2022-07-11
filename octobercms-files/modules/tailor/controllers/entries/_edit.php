<?php if (!$this->fatalError): ?>
    <?= Form::open(['class'=>'layout stretch', 'data-change-monitor'=>1, 'data-window-close-confirm'=>"There is unsaved data", 'id'=>'tailor-form']) ?>
        <div class="layout-row">
            <div class="padded-container layout form-document-layout">
                <div class="layout-row min-size">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <?= $this->formRenderOutsideFields() ?>
                        </div>
                        <div data-vue-container="entryHeaderControls">
                            <div class="record-management-controls">
                                <?php if ($this->vars['initialState']['showEntryTypeSelector']): ?>
                                    <backend-component-dropdownmenubutton
                                        :menuitems="state.entryTypeOptions"
                                        preferable-menu-position="bottom-right"
                                        css-class="record-management-button has-menu entry-type-selector"
                                        :current-label-command="state.initial.contentGroup"
                                        :disabled="state.toolbarDisabled"
                                        @command="onSetEntryType"
                                    ></backend-component-dropdownmenubutton>
                                <?php endif ?>

                                <tailor-component-publishbutton
                                    @click="onPublishingControlsBtnClick"
                                    :state="state"
                                ></tailor-component-publishbutton>
                            </div>

                            <tailor-component-publishingcontrols
                                :lang="state.lang"
                                :entry-state="state"
                                ref="publishingControls"
                                @statechanged="onPublishingStateChanged"
                                @publishdraftclick="onPublishDraftClick"
                            ></tailor-component-publishingcontrols>
                        </div>
                    </div>
                </div>

                <div
                    class="layout-row min-size"
                    data-vue-container
                    data-lang-form-save="<?= e(Lang::get('backend::lang.form.save')) ?>"
                    data-lang-save-draft="<?= e(Lang::get('tailor::lang.edit.save_draft')) ?>"
                    data-lang-discard-draft="<?= e(Lang::get('tailor::lang.edit.discard_draft')) ?>"
                    data-lang-discard-draft-confirm="<?= e(Lang::get('tailor::lang.edit.discard_draft_confirm')) ?>"
                    data-lang-save-apply-draft="<?= e(Lang::get('tailor::lang.edit.save_apply_draft')) ?>"
                    data-lang-form-delete="<?= e(Lang::get('backend::lang.form.delete')) ?>"
                    data-lang-delete-entry-confirm="<?= e(Lang::get('tailor::lang.edit.delete_entry_confirm')) ?>"
                    data-lang-form-error="<?= e(Lang::get('backend::lang.form.error')) ?>"
                    data-lang-form-confirm-delete="<?= e(Lang::get('backend::lang.form.confirm_delete')) ?>"
                    data-lang-create-draft="<?= e(Lang::get('tailor::lang.edit.create_draft')) ?>"
                    data-lang-select-draft="<?= e(Lang::get('tailor::lang.edit.select_draft')) ?>"
                    data-lang-edit-primary-record="<?= e(Lang::get('tailor::lang.edit.edit_primary_record')) ?>"
                    data-lang-unnamed-draft="<?= e(Lang::get('tailor::lang.edit.unnamed_draft')) ?>"
                    data-lang-draft-notes="<?= e(Lang::get('tailor::lang.edit.draft_notes')) ?>"
                    data-lang-confirm-create-draft="<?= e(Lang::get('tailor::lang.edit.confirm_leave_create_draft')) ?>"
                    data-lang-form-save-close="<?= e(Lang::get('backend::lang.form.save_and_close')) ?>"
                    data-lang-preview="<?= e(Lang::get('tailor::lang.edit.preview')) ?>"
                >
                    <div class="compensate-container-padding-h">
                        <template
                        >
                            <backend-component-document
                                :processing="state.processing"
                                :toolbar-command-event-bus="state.eventBus"
                            >
                                <template v-slot:toolbar>
                                    <backend-component-document-toolbar
                                        :elements="state.toolbarElements"
                                        @command="onCommand"
                                        :disabled="state.toolbarDisabled"
                                    ></backend-component-document-toolbar>
                                </template>
                                <template v-slot:drawer>
                                    <tailor-component-draftnotes
                                        v-if="state.showDraftNotesUI"
                                        v-show="state.showDraftNotes"
                                        ref="draftNotes"
                                        :state="state"
                                    >
                                    </tailor-component-draftnotes>
                                </template>
                            </backend-component-document>
                        </template>
                    </div>

                    <div style="display:none">
                        <?= $this->formRenderSecondaryTabs() ?>
                    </div>
                </div>

                <div class="layout-row" id="entryPrimaryTabs">
                    <?= $this->makePartial('primary_tabs') ?>
                </div>
            </div>
        </div>
    <?= Form::close() ?>

    <script data-vue-state="initial" type="text/template"><?= json_encode($initialState) ?></script>
<?php else: ?>
    <p class="flash-message static error"><?= e(trans($this->fatalError)) ?></p>

    <p><?= BackendUi::button()->label('Return to Entries')->linkTo('tailor/entries') ?></p>
<?php endif ?>