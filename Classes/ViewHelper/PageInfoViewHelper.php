<?php

namespace KoninklijkeCollective\MyUserManagement\ViewHelper;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Retrieve page information
 *
 * @package KoninklijkeCollective\MyUserManagement\ViewHelpers
 */
class PageInfoViewHelper extends AbstractViewHelper
{

    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * Arguments
     */
    public function initializeArguments()
    {
        $this->registerArgument('pageId', 'int', 'Page uid', true);
        $this->registerArgument('as', 'string', 'Render as', false, 'page');
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $as = $arguments['as'];
        $pageId = $arguments['pageId'];

        $variableContainer = $renderingContext->getVariableProvider();
        $variableContainer->add($as, static::getPageRow($pageId));
        $output = $renderChildrenClosure();
        $variableContainer->remove($as);

        return $output;
    }

    /**
     * @return \TYPO3\CMS\Frontend\Page\PageRepository
     */
    protected static function getPageRow($pageId)
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('pages')
            ->select(['*'], 'pages', ['uid' => $pageId])
            ->fetch();
    }
}
