<?php

namespace KoninklijkeCollective\MyUserManagement\Service;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Service: Logs
 *
 * @package KoninklijkeCollective\MyUserManagement\Service
 */
class LogService implements \TYPO3\CMS\Core\SingletonInterface
{

    /**
     * Default static values for readability
     */
    const TYPE_LOGGED_IN = 255;
    const ACTION_LOG_IN = 1;

    /**
     * Find login actions from sys_log
     *
     * @param array $parameters
     * @return array
     */
    public function findUserLoginActions($parameters = null)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('sys_log');
        $expr = $queryBuilder->expr();

        $queryBuilder
            ->select('sys_log.*')
            ->from('sys_log')
            ->join(
                'sys_log',
                'be_users',
                'be_users',
                $expr->eq(
                    'sys_log.userid',
                    $queryBuilder->quoteIdentifier('be_users.uid')
                )
            )
            ->where(
                $expr->gt(
                    'sys_log.userid',
                    $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT)
                ),
                $expr->gt(
                    'sys_log.tstamp',
                    $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT)
                ),
                $expr->eq(
                    'sys_log.level',
                    $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT)
                ),
                $expr->eq(
                    'sys_log.type',
                    $queryBuilder->createNamedParameter(self::TYPE_LOGGED_IN, \PDO::PARAM_INT)
                ),
                $expr->eq(
                    'sys_log.action',
                    $queryBuilder->createNamedParameter(self::ACTION_LOG_IN, \PDO::PARAM_INT)
                )
            );

        // Set parameter query parts
        if (!empty($parameters)) {
            if ($parameters['user'] !== null) {
                $queryBuilder->andWhere(
                    $expr->eq(
                        'sys_log.userid',
                        $queryBuilder->createNamedParameter((int)$parameters['user'], \PDO::PARAM_INT)
                    )
                );
            }
            if ((bool)$parameters['hide-admin'] === true) {
                $queryBuilder->andWhere(
                    $expr->eq(
                        'be_users.admin',
                        $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT)
                    )
                );
            }
        }

        // Set default variables for output
        $logs = [];

        // Apply pagination
        $limit = null;
        if ((!empty($parameters)) && $parameters['itemsPerPage'] !== null) {

            $limit = (int)$parameters['itemsPerPage'];
            $offset = 0;

            if ($parameters['page'] !== null) {
                $offset = $limit * ((int)$parameters['page'] - 1);
            }
        }
        $statement = $queryBuilder
            ->setMaxResults($limit ?? 999)
            ->setFirstResult($offset ?? 0)
            ->orderBy('sys_log.tstamp', 'desc')
            ->execute();

        while ($row = $statement->fetch()) {
            $data = unserialize($row['log_data']);
            $logs['items'][] = [
                'user_id' => $row['userid'],
                'user_login' => $data[0],
                'user_ip' => $row['IP'],
                'tstamp' => $row['tstamp'],
            ];
        }

        return $logs;
    }
}
