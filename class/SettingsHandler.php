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
 * Class Object Handler Settings
 */
class SettingsHandler extends \XoopsPersistableObjectHandler
{
	/**
	 * Constructor
	 *
	 * @param \XoopsDatabase $db
	 */
	public function __construct(\XoopsDatabase $db)
	{
		parent::__construct($db, 'wggithub_settings', Settings::class, 'set_id', 'set_token');
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
	 * Get Count Settings in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	public function getCountSettings($start = 0, $limit = 0, $sort = 'set_id ASC, set_token', $order = 'ASC')
	{
		$crCountSettings = new \CriteriaCompo();
		$crCountSettings = $this->getSettingsCriteria($crCountSettings, $start, $limit, $sort, $order);
		return $this->getCount($crCountSettings);
	}

	/**
	 * Get All Settings in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return array
	 */
	public function getAllSettings($start = 0, $limit = 0, $sort = 'set_id ASC, set_token', $order = 'ASC')
	{
		$crAllSettings = new \CriteriaCompo();
		$crAllSettings = $this->getSettingsCriteria($crAllSettings, $start, $limit, $sort, $order);
		return $this->getAll($crAllSettings);
	}

	/**
	 * Get Criteria Settings
	 * @param        $crSettings
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	private function getSettingsCriteria($crSettings, $start, $limit, $sort, $order)
	{
		$crSettings->setStart($start);
		$crSettings->setLimit($limit);
		$crSettings->setSort($sort);
		$crSettings->setOrder($order);
		return $crSettings;
	}
}
