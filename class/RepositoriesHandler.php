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
 * Class Object Handler Repositories
 */
class RepositoriesHandler extends \XoopsPersistableObjectHandler
{
	/**
	 * Constructor
	 *
	 * @param \XoopsDatabase $db
	 */
	public function __construct(\XoopsDatabase $db)
	{
		parent::__construct($db, 'wggithub_repositories', Repositories::class, 'repo_id', 'repo_name');
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
	 * Get Count Repositories in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	public function getCountRepositories($start = 0, $limit = 0, $sort = 'repo_id ASC, repo_name', $order = 'ASC')
	{
		$crCountRepositories = new \CriteriaCompo();
		$crCountRepositories = $this->getRepositoriesCriteria($crCountRepositories, $start, $limit, $sort, $order);
		return $this->getCount($crCountRepositories);
	}

	/**
	 * Get All Repositories in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return array
	 */
	public function getAllRepositories($start = 0, $limit = 0, $sort = 'repo_id ASC, repo_name', $order = 'ASC')
	{
		$crAllRepositories = new \CriteriaCompo();
		$crAllRepositories = $this->getRepositoriesCriteria($crAllRepositories, $start, $limit, $sort, $order);
		return $this->getAll($crAllRepositories);
	}

	/**
	 * Get Criteria Repositories
	 * @param        $crRepositories
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	private function getRepositoriesCriteria($crRepositories, $start, $limit, $sort, $order)
	{
		$crRepositories->setStart($start);
		$crRepositories->setLimit($limit);
		$crRepositories->setSort($sort);
		$crRepositories->setOrder($order);
		return $crRepositories;
	}
}
