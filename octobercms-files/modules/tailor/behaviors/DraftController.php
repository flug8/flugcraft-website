<?php namespace Tailor\Behaviors;

use Flash;
use Redirect;
use Backend\Classes\ControllerBehavior;
use Backend\Behaviors\FormController;
use Exception;
use Lang;

/**
 * DraftController is a modifier to FormController to enable draft records
 *
 * @package october\backend
 * @author Alexey Bobkov, Samuel Georges
 */
class DraftController extends ControllerBehavior
{
    use \Backend\Traits\FormModelSaver;

    /**
     * @var Model model used by the form
     */
    protected $primaryModel;

    /**
     * @var Model model used by the form
     */
    protected $model;

    /**
     * @var string draftId
     */
    protected $draftId;

    /**
     * initDraft
     */
    public function initDraft($model)
    {
        $this->primaryModel = $model;

        if ($this->isDraftMode()) {
            $draftModel = $this->controller->formFindModelObject($this->getDraftId());

            $this->controller->initForm($draftModel, FormController::CONTEXT_UPDATE);

            $this->model = $draftModel;

            $this->draftId = $draftModel->getKey();
        }
        else {
            $this->controller->initForm($model);

            $this->model = $model;
        }
    }

    /**
     * Controller "create" action used for creating new model records.
     *
     * @param string $context Form context
     * @return void
     */
    public function create()
    {
        $model = $this->controller->formCreateModelObject();

        $model->is_enabled = true;

        $model->saveAsFirstDraft(['name' => __('First Draft')]);

        return $this->draftGetRedirectUrl(FormController::CONTEXT_UPDATE, $model);
    }

    /**
     * Controller "update" action used for updating existing model records.
     *
     * @param int $recordId Record identifier
     * @param string $context Form context
     * @return void
     */
    public function update($recordId = null)
    {
        try {
            $model = $this->controller->formFindModelObject($recordId);

            $this->initDraft($model);
        }
        catch (Exception $ex) {
            $this->controller->handleError($ex);
        }
    }

    /**
     * onCommitDraft is saving a draft without publishing it
     */
    public function onCommitDraft($recordId = null)
    {
        $model = $this->controller->formFindModelObject($recordId);

        $this->initDraft($model);

        $draftModel = $this->draftGetDraftModel();

        $draftModel->setDraftCommit((array) post('Draft'));

        $formWidget = $this->controller->formGetWidget();

        $this->controller->formBeforeSave($model);

        $this->performSaveOnModel($draftModel, $formWidget->getSaveData(), $formWidget->getSessionKey());

        $this->controller->formAfterSave($model);

        Flash::success(__('Draft Saved'));

        return $this->draftGetRedirectUrl(FormController::CONTEXT_UPDATE, $model);
    }

    /**
     * onPublishDraft is saving a draft and publishing it
     */
    public function onPublishDraft($recordId = null, $context = null)
    {
        $model = $this->controller->formFindModelObject($recordId);

        $isFirstDraft = $model->isFirstDraftStatus();

        $this->initDraft($model);

        $model->setDraftPublish();

        $formWidget = $this->controller->formGetWidget();

        $this->controller->formBeforeSave($model);

        $this->performSaveOnModel($model, $formWidget->getSaveData(), $formWidget->getSessionKey());

        $this->controller->formAfterSave($model);

        if (!$isFirstDraft) {
            $draftModel = $this->draftGetDraftModel();

            $draftModel->delete();
        }

        Flash::success(__('Draft Applied'));

        return $this->controller->makeRedirect(FormController::CONTEXT_UPDATE, $model);
    }

    /**
     * onCreateDraft is creating a new draft from a published record
     */
    public function onCreateDraft($recordId = null, $context = null)
    {
        $model = $this->controller->formFindModelObject($recordId);

        $this->initDraft($model);

        $draftName = Lang::get('tailor::lang.edit.draft').' '.($model->countDrafts() + 1);

        $newModel = $model->createNewDraft([
            'name' => $draftName,
            'notes' => $draftName.': '.Lang::get('tailor::lang.edit.draft_notes_prompt')
        ]);

        $this->draftId = $newModel->getKey();

        Flash::success(__('Draft Created'));

        return $this->draftGetRedirectUrl(FormController::CONTEXT_UPDATE, $model);
    }

    /**
     * onDiscardDraft deletes the draft
     */
    public function onDiscardDraft($recordId = null, $context = null)
    {
        $model = $this->controller->formFindModelObject($recordId);

        $this->initDraft($model);

        $draftModel = $this->draftGetDraftModel();

        $draftModel->delete();

        Flash::success(__('Draft Discarded'));

        if ($redirect = $this->controller->makeRedirect('update', $model)) {
            return $redirect;
        }
    }

    /**
     * draftGetPrimaryModel
     */
    public function draftGetPrimaryModel()
    {
        return $this->primaryModel;
    }

    /**
     * draftGetDraftModel
     */
    public function draftGetDraftModel()
    {
        return $this->model;
    }

    /**
     * getDraftId
     */
    public function getDraftId(): string
    {
        if ($this->draftId) {
            return $this->draftId;
        }

        return (string) get('draft');
    }

    /**
     * isDraftMode
     */
    public function isDraftMode(): bool
    {
        return (bool) $this->getDraftId();
    }

    /**
     * formGetRedirectUrl
     */
    public function draftGetRedirectUrl($context = null, $model = null)
    {
        $url = $this->controller->makeRedirect($context, $model);

        if ($url instanceof \Illuminate\Http\RedirectResponse) {
            $url = $url->getTargetUrl();
        }

        // Escaping draft mode
        if (post('close')) {
            return Redirect::to($url);
        }

        // Redirect back to the same page
        if ($this->isDraftMode()) {
            $url .= '?draft=' . $this->getDraftId();
        }
        elseif ($model->isDraftStatus()) {
            $url .= '?draft=' . $model->getKey();
        }

        return Redirect::to($url);
    }
}
