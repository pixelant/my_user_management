<?php
namespace KoninklijkeCollective\MyUserManagement\ViewHelper;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Displays link with sprite icon with confirm message
 *
 * @package KoninklijkeCollective\MyRedirects\ViewHelpers
 */
class LinkConfirmViewHelper extends AbstractViewHelper
{

    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        $this->registerArgument('link', 'string', 'Link', false, '');
        $this->registerArgument('message', 'string', 'Message', false, '');
        $this->registerArgument('title', 'string', 'Title', false, '');
        $this->registerArgument('class', 'string', 'Class', false, '');
        $this->registerArgument('icon', 'string', 'Icon', false, 'actions-edit-delete');
    }

    /**
     * Render confirm link with sprite icon
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $link = $arguments['link'];
        $message = $arguments['message'];
        $title = $arguments['title'];
        $class = $arguments['class'];
        $icon = $arguments['icon'];

        if (!empty($link)) {
            /** @var \TYPO3\CMS\Core\Imaging\IconFactory $iconFactory */
            $iconFactory = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconFactory::class);
            $attributes = [
                'href' => $link,
                'data-severity' => 'warning',
                'data-title' => $title,
                'data-content' => $message,
                'data-button-close-text' => $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_common.xlf:cancel'),
                'class' => 'btn btn-default t3js-modal-trigger' . ($class ? ' ' . $class : ''),
            ];
            return '<a ' . GeneralUtility::implodeAttributes($attributes, true, true) . '>'
                . $iconFactory->getIcon($icon, \TYPO3\CMS\Core\Imaging\Icon::SIZE_SMALL)
                . '</a>';
        }
        return '';
    }
}
