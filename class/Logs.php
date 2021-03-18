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

\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Logs
 */
class Logs extends \XoopsObject
{
    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('log_id', \XOBJ_DTYPE_INT);
        $this->initVar('log_type', \XOBJ_DTYPE_INT);
        $this->initVar('log_details', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('log_result', \XOBJ_DTYPE_TXTAREA);
        $this->initVar('log_datecreated', \XOBJ_DTYPE_INT);
        $this->initVar('log_submitter', \XOBJ_DTYPE_INT);
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
    public function getNewInsertedIdLogs()
    {
        $newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
        return $newInsertedId;
    }

    /**
     * @public function getForm
     * @param bool $action
     * @param int  $start
     * @param int  $limit
     * @return \XoopsThemeForm
     */
    public function getFormLogs($action = false, $start = 0, $limit = 0)
    {
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        // Title
        $title = $this->isNew() ? \sprintf(\_AM_WGGITHUB_LOG_ADD) : \sprintf(\_AM_WGGITHUB_LOG_EDIT);
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        $logTypeSelect = new \XoopsFormSelect(\_AM_WGGITHUB_LOG_TYPE, 'log_type', $this->getVar('log_type'));
        $logTypeSelect->addOption(Constants::LOG_TYPE_NONE, \_AM_WGGITHUB_LOG_TYPE_NONE);
        $logTypeSelect->addOption(Constants::LOG_TYPE_UPDATE_START, \_AM_WGGITHUB_LOG_TYPE_UPDATE_START);
        $logTypeSelect->addOption(Constants::LOG_TYPE_UPDATE_END, \_AM_WGGITHUB_LOG_TYPE_UPDATE_END);
        $logTypeSelect->addOption(Constants::LOG_TYPE_REQUEST, \_AM_WGGITHUB_LOG_TYPE_REQUEST);
        $logTypeSelect->addOption(Constants::LOG_TYPE_ERROR, \_AM_WGGITHUB_LOG_TYPE_ERROR);
        $form->addElement($logTypeSelect);
        // Form Text logDetails
        $form->addElement(new \XoopsFormText(\_AM_WGGITHUB_LOG_DETAILS, 'log_details', 50, 255, $this->getVar('log_details')), true);
        // Form Text logResult
        $form->addElement(new \XoopsFormTextArea(\_AM_WGGITHUB_LOG_RESULT, 'log_result', $this->getVar('log_result', 'e'), 4, 47));
        // Form Text Date Select logDatecreated
        $logDatecreated = $this->isNew() ?: $this->getVar('log_datecreated');
        $form->addElement(new \XoopsFormTextDateSelect(\_AM_WGGITHUB_LOG_DATECREATED, 'log_datecreated', '', $logDatecreated));
        // Form Select User reqSubmitter
        $form->addElement(new \XoopsFormSelectUser(\_AM_WGGITHUB_LOG_SUBMITTER, 'log_submitter', false, $this->getVar('log_submitter')));
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'save'));
        $form->addElement(new \XoopsFormHidden('start', $start));
        $form->addElement(new \XoopsFormHidden('limit', $limit));
        $form->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));
        return $form;
    }

    /**
     * Get Values
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
    public function getValuesLogs($keys = null, $format = null, $maxDepth = null)
    {
        $helper  = \XoopsModules\Wggithub\Helper::getInstance();
        $utility = new \XoopsModules\Wggithub\Utility();
        $editorMaxchar = $helper->getConfig('editor_maxchar');
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id']           = $this->getVar('log_id');
        $ret['type']         = $this->getVar('log_type');
        switch ($ret['type']) {
            case Constants::LOG_TYPE_NONE:
            default:
                $type_text = \_AM_WGGITHUB_LOG_TYPE_NONE;
                break;
            case Constants::LOG_TYPE_UPDATE_START:
                $type_text = \_AM_WGGITHUB_LOG_TYPE_UPDATE_START;
                break;
            case Constants::LOG_TYPE_UPDATE_END:
                $type_text = \_AM_WGGITHUB_LOG_TYPE_UPDATE_END;
                break;
            case Constants::LOG_TYPE_REQUEST:
                $type_text = \_AM_WGGITHUB_LOG_TYPE_REQUEST;
                break;
            case Constants::LOG_TYPE_ERROR:
                $type_text = \_AM_WGGITHUB_LOG_TYPE_ERROR;
                break;
        }
        $ret['type_text']    = $type_text;
        $ret['details']      = $this->getVar('log_details');
        $ret['result']       = \strip_tags($this->getVar('log_result', 'e'));
        $ret['result_short'] = $utility::truncateHtml($ret['result'], $editorMaxchar);
        $ret['datecreated']  = \formatTimestamp($this->getVar('log_datecreated'), 'm');
        $ret['submitter']    = \XoopsUser::getUnameFromId($this->getVar('log_submitter'));
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
