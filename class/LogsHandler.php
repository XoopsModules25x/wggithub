<?php

namespace XoopsModules\Wggithub;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * wgGitHub module for xoops
 *
 * @copyright      2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        wggithub
 * @since          1.0
 * @min_xoops      2.5.10
 * @author         Goffy - XOOPS Development Team - Email:<goffy@wedega.com> - Website:<https://wedega.com>
 */

use XoopsModules\Wggithub;


/**
 * Class Object Handler Logs
 */
class LogsHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wggithub_logs', Logs::class, 'log_id', 'log_detail');
    }

    /**
     * @param bool $isNew
     *
     * @return object
     */
    public function create($isNew = true)
    {
        return parent::create($isNew);
    }

    /**
     * retrieve a field
     *
     * @param int $i field id
     * @param null fields
     * @return mixed reference to the {@link Get} object
     */
    public function get($i = null, $fields = null)
    {
        return parent::get($i, $fields);
    }

    /**
     * get inserted id
     *
     * @param null
     * @return int reference to the {@link Get} object
     */
    public function getInsertId()
    {
        return $this->db->getInsertId();
    }

    /**
     * Get Count Logs in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountLogs($start = 0, $limit = 0, $sort = 'log_id', $order = 'ASC')
    {
        $crCountLogs = new \CriteriaCompo();
        $crCountLogs = $this->getLogsCriteria($crCountLogs, $start, $limit, $sort, $order);
        return $this->getCount($crCountLogs);
    }

    /**
     * Get All Logs in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllLogs($start = 0, $limit = 0, $sort = 'log_id', $order = 'ASC')
    {
        $crAllLogs = new \CriteriaCompo();
        $crAllLogs = $this->getLogsCriteria($crAllLogs, $start, $limit, $sort, $order);
        return $this->getAll($crAllLogs);
    }

    /**
     * Get Criteria Logs
     * @param        $crLogs
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    private function getLogsCriteria($crLogs, $start, $limit, $sort, $order)
    {
        $crLogs->setStart($start);
        $crLogs->setLimit($limit);
        $crLogs->setSort($sort);
        $crLogs->setOrder($order);
        return $crLogs;
    }

    /**
     * Update table requests
     *
     * @param int    $type
     * @param string $detail
     * @param string $result
     * @return bool
     */
    public function updateTableLogs($type, $detail, $result)
    {
        $helper = Wggithub\Helper::getInstance();
        $logsHandler = $helper->getHandler('Logs');

        $submitter = isset($GLOBALS['xoopsUser']) && \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar('uid') : 0;

        // add item to table logs
        $logsObj = $logsHandler->create();
        $logsObj->setVar('log_type', $type);
        $logsObj->setVar('log_details', $detail);
        $logsObj->setVar('log_result', $result);
        $logsObj->setVar('log_datecreated',time());
        $logsObj->setVar('log_submitter', $submitter);
        // Insert Data
        if ($logsHandler->insert($logsObj)) {
            return true;
        }

        return false;
    }

}
