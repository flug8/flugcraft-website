<?php namespace Tailor\Controllers;

use BackendMenu;
use Tailor\Models\GlobalRecord;
use Tailor\Classes\BlueprintIndexer;
use Backend\Classes\WildcardController;
use ApplicationException;
use ForbiddenException;

/**
 * Globals controller
 *
 * @package october\tailor
 * @author Alexey Bobkov, Samuel Georges
 */
class Globals extends WildcardController
{
    /**
     * @var array implement extensions
     */
    public $implement = [
        \Backend\Behaviors\FormController::class
    ];

    /**
     * @var string formConfig is `FormController` configuration.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var GlobalBlueprint activeSource
     */
    protected $activeSource;

    /**
     * beforeDisplay
     */
    public function beforeDisplay()
    {
        // Pop off first parameter as source handle
        $sourceHandle = array_shift($this->params);

        $this->makeBlueprintSource($sourceHandle);

        if (!$this->activeSource) {
            $this->handleError(new ApplicationException("Cannot find [${sourceHandle}] global"));
            return;
        }

        $this->checkSourcePermission();

        $this->setNavigationContext();
    }

    /**
     * index action
     */
    public function index()
    {
        if ($this->hasFatalError()) {
            return;
        }

        $this->pageTitle = 'Update Global';

        $this->asExtension('FormController')->update();

        $this->prepareVars();
    }

    /**
     * prepareVars
     */
    protected function prepareVars()
    {
        $this->vars['entityName'] = $this->activeSource->name ?? '';
        $this->vars['activeSource'] = $this->activeSource;
    }

    /**
     * onSave
     */
    public function onSave()
    {
        return $this->asExtension('FormController')->update_onSave();
    }

    /**
     * formFindModelObject
     */
    public function formFindModelObject($recordId)
    {
        return GlobalRecord::findForGlobalUuid($this->activeSource->uuid);
    }

    /**
     * makeBlueprintSource
     */
    protected function makeBlueprintSource($activeSource = null)
    {
        if (!$activeSource) {
            $this->activeSource = BlueprintIndexer::instance()->listGlobals()[0] ?? null;
        }
        else {
            $this->activeSource = $activeSource
                ? BlueprintIndexer::instance()->findGlobalByHandle($activeSource)
                : null;
        }
    }

    /**
     * checkSourcePermission
     */
    protected function checkSourcePermission($permissionName = null, $throwException = true)
    {
        $hasPermission = $this->user->hasAnyAccess([$this->activeSource->getPermissionCodeName($permissionName)]);

        if ($throwException && !$hasPermission) {
            throw new ForbiddenException;
        }

        return $hasPermission;
    }

    /**
     * hasSourcePermission
     */
    protected function hasSourcePermission($permissionName = null)
    {
        return $this->checkSourcePermission($permissionName, false);
    }

    /**
     * setNavigationContext
     */
    protected function setNavigationContext()
    {
        $item = BlueprintIndexer::instance()->findSecondaryNavigation($this->activeSource->uuid);
        if ($item) {
            $item->setBackendControllerContext();
        }
        else {
            BackendMenu::setContext('October.Tailor', 'tailor');
        }
    }
}
