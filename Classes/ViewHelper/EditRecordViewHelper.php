<?php

namespace KoninklijkeCollective\MyUserManagement\ViewHelper;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Edit Record ViewHelper, see FormEngine logic
 *
 * @internal
 */
class EditRecordViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
        $this->registerArgument('parameters', 'string', 'Parameters', true);
    }

    /**
     * Returns a URL to link to FormEngine
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed|string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $parameters = GeneralUtility::explodeUrl2Array($arguments['parameters']);
        return BackendUtility::getModuleUrl('record_edit', $parameters);
    }
}