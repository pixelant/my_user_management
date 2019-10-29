<?php

namespace KoninklijkeCollective\MyUserManagement\ViewHelper;

use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Resource\ResourceStorage;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ViewHelper: Storage Location
 *
 * @package KoninklijkeCollective\MyUserManagement\ViewHelpers
 */
class StorageLocationViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
        $this->registerArgument('storageId', 'int', 'Storage Id', true);
        $this->registerArgument('location', 'string', 'location', false, '/');
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $storageId = $arguments['storageId'];
        $location = $arguments['location'];

        /** @var ResourceStorage $storage */
        $storage = ResourceFactory::getInstance()->getStorageObject($storageId);

        if ($storage instanceof ResourceStorage) {
            $folder = null;
            try {
                $folder = $storage->getFolder($location);
            } catch (\Exception $e) {
            }

            if ($folder instanceof \TYPO3\CMS\Core\Resource\Folder) {
                $output = $folder->getPublicUrl();
            }
        }

        if (empty($output)) {
            $output = $storageId . ': ' . $location;
        }

        return $output;
    }
}
