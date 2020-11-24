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
 * @author         TDM XOOPS - Email:<goffy@wedega.com> - Website:<https://wedega.com>
 */

use XoopsModules\Wggithub;


/**
 * Class Object Handler Requests
 */
class RequestsHandler extends \XoopsPersistableObjectHandler
{
	/**
	 * Constructor
	 *
	 * @param \XoopsDatabase $db
	 */
	public function __construct(\XoopsDatabase $db)
	{
		parent::__construct($db, 'wggithub_requests', Requests::class, 'req_id', 'req_request');
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
	 * Get Count Requests in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	public function getCountRequests($start = 0, $limit = 0, $sort = 'req_id ASC, req_request', $order = 'ASC')
	{
		$crCountRequests = new \CriteriaCompo();
		$crCountRequests = $this->getRequestsCriteria($crCountRequests, $start, $limit, $sort, $order);
		return $this->getCount($crCountRequests);
	}

	/**
	 * Get All Requests in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return array
	 */
	public function getAllRequests($start = 0, $limit = 0, $sort = 'req_id ASC, req_request', $order = 'ASC')
	{
		$crAllRequests = new \CriteriaCompo();
		$crAllRequests = $this->getRequestsCriteria($crAllRequests, $start, $limit, $sort, $order);
		return $this->getAll($crAllRequests);
	}

	/**
	 * Get Criteria Requests
	 * @param        $crRequests
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	private function getRequestsCriteria($crRequests, $start, $limit, $sort, $order)
	{
		$crRequests->setStart($start);
		$crRequests->setLimit($limit);
		$crRequests->setSort($sort);
		$crRequests->setOrder($order);
		return $crRequests;
	}

    /**
     * Update table requests
     *
     * @param string $request
     * @param string $result
     * @return boolean
     */
    public function updateTableRequests($request, $result)
    {
        $helper = Wggithub\Helper::getInstance();
        $requestsHandler = $helper->getHandler('Requests');

        $submitter = isset($GLOBALS['xoopsUser']) && \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar('uid') : 0;

        // add request to table requests
        $requestsObj = $requestsHandler->create();
        $requestsObj->setVar('req_request', $request);
        $requestsObj->setVar('req_result', $result);
        $requestsObj->setVar('req_datecreated',time());
        $requestsObj->setVar('req_submitter', $submitter);
        // Insert Data
        if ($requestsHandler->insert($requestsObj)) {
            return true;
        }

        return false;
    }

}
