<?php

namespace KoninklijkeCollective\MyUserManagement\ViewHelper;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Remove Record ViewHelper, see FormEngine logic
 *
 * @internal
 */
class RemoveRecordViewHelper extends AbstractViewHelper
{

    public function initializeArguments()
    {
        $this->registerArgument('parameters', 'string', 'Parameters', true);
    }

    /**
     * Returns a URL to link to quick command
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $parameters = GeneralUtility::explodeUrl2Array($arguments['parameters']);

        $parameters['prErr'] = 1;
        $parameters['uPT'] = 1;

        return BackendUtility::getModuleUrl('tce_db', $parameters);
    }
}
