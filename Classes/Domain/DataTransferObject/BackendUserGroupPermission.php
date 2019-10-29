<?php
namespace KoninklijkeCollective\MyUserManagement\Domain\DataTransferObject;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * DTO: Permission access Backend User Groups
 *
 * @package KoninklijkeCollective\MyUserManagement\Domain\Model\DataTransferObject
 */
class BackendUserGroupPermission extends AbstractPermission
{

    /**
     * @var string
     */
    const KEY = 'my_user_management_group_permissions';

    /**
     * @return void
     */
    protected function populateData()
    {
        $this->data = [
            'header' => 'LLL:EXT:my_user_management/Resources/Private/Language/locallang.xlf:backend_access_group_permissions',
            'items' => [],
        ];
        $groups = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('be_groups')
            ->select(['*'], 'be_groups')
            ->fetchAll();

        foreach ($groups as $group) {
            $this->data['items'][$group['uid']] = [
                $group['title'],
                'EXT:my_user_management/Resources/Public/Icons/table-user-group-backend.svg',
                $group['description'],
            ];
        }
    }

}
