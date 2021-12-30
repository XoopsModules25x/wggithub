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

\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Requests
 */
class Requests extends \XoopsObject
{
	/**
	 * Constructor
	 *
	 * @param null
	 */
	public function __construct()
	{
		$this->initVar('req_id', \XOBJ_DTYPE_INT);
		$this->initVar('req_request', \XOBJ_DTYPE_TXTBOX);
		$this->initVar('req_result', \XOBJ_DTYPE_TXTBOX);
		$this->initVar('req_datecreated', \XOBJ_DTYPE_INT);
		$this->initVar('req_submitter', \XOBJ_DTYPE_INT);
	}

	/**
	 * @static function &getInstance
	 *
	 * @param null
	 */
	public static function getInstance()
	{
		static $instance = false;
		if (!$instance) {
			$instance = new self();
		}
	}

	/**
	 * The new inserted $Id
	 * @return inserted id
	 */
	public function getNewInsertedIdRequests()
	{
		$newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
		return $newInsertedId;
	}

	/**
	 * @public function getForm
	 * @param bool $action
	 * @return \XoopsThemeForm
	 */
	public function getFormRequests($action = false)
	{
		$helper = \XoopsModules\Wggithub\Helper::getInstance();
		if (!$action) {
			$action = $_SERVER['REQUEST_URI'];
		}
		$isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
		// Title
		$title = $this->isNew() ? \sprintf(\_AM_WGGITHUB_REQUEST_ADD) : \sprintf(\_AM_WGGITHUB_REQUEST_EDIT);
		// Get Theme Form
		\xoops_load('XoopsFormLoader');
		$form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		// Form Text reqRequest
		$form->addElement(new \XoopsFormText(\_AM_WGGITHUB_REQUEST_REQUEST, 'req_request', 50, 255, $this->getVar('req_request')), true);
		// Form Text reqResult
		$form->addElement(new \XoopsFormText(\_AM_WGGITHUB_REQUEST_RESULT, 'req_result', 50, 255, $this->getVar('req_result')));
		// Form Text Date Select reqDatecreated
		$reqDatecreated = $this->isNew() ?: $this->getVar('req_datecreated');
		$form->addElement(new \XoopsFormTextDateSelect(\_AM_WGGITHUB_REQUEST_DATECREATED, 'req_datecreated', '', $reqDatecreated));
		// Form Select User reqSubmitter
		$form->addElement(new \XoopsFormSelectUser(\_AM_WGGITHUB_REQUEST_SUBMITTER, 'req_submitter', false, $this->getVar('req_submitter')));
		// To Save
		$form->addElement(new \XoopsFormHidden('op', 'save'));
		$form->addElement(new \XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));
		return $form;
	}

	/**
	 * Get Values
	 * @param null $keys
	 * @param null $format
	 * @param null $maxDepth
	 * @return array
	 */
	public function getValuesRequests($keys = null, $format = null, $maxDepth = null)
	{
		$ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id']          = $this->getVar('req_id');
		$ret['request']     = $this->getVar('req_request');
		$ret['result']      = $this->getVar('req_result');
		$ret['datecreated'] = \formatTimestamp($this->getVar('req_datecreated'), 's');
		$ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('req_submitter'));
		return $ret;
	}

	/**
	 * Returns an array representation of the object
	 *
	 * @return array
	 */
	public function toArrayRequests()
	{
		$ret = [];
		$vars = $this->getVars();
		foreach (\array_keys($vars) as $var) {
			$ret[$var] = $this->getVar('"{$var}"');
		}
		return $ret;
	}
}
