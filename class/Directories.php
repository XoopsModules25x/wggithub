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
use XoopsModules\Wggithub\Constants;

\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Directories
 */
class Directories extends \XoopsObject
{
    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('dir_id', \XOBJ_DTYPE_INT);
        $this->initVar('dir_name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('dir_descr', \XOBJ_DTYPE_OTHER);
        $this->initVar('dir_type', \XOBJ_DTYPE_INT);
        $this->initVar('dir_content', \XOBJ_DTYPE_INT);
        $this->initVar('dir_autoupdate', \XOBJ_DTYPE_INT);
        $this->initVar('dir_online', \XOBJ_DTYPE_INT);
        $this->initVar('dir_filterrelease', \XOBJ_DTYPE_INT);
        $this->initVar('dir_weight', \XOBJ_DTYPE_INT);
        $this->initVar('dir_datecreated', \XOBJ_DTYPE_INT);
        $this->initVar('dir_submitter', \XOBJ_DTYPE_INT);
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
    public function getNewInsertedIdDirectories()
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
    public function getFormDirectories($action = false, $start = 0, $limit = 0)
    {
        $helper = \XoopsModules\Wggithub\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        $isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());

        // Title
        $title = $this->isNew() ? \sprintf(\_AM_WGGITHUB_DIRECTORY_ADD) : \sprintf(\_AM_WGGITHUB_DIRECTORY_EDIT);
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Text dirName
        $form->addElement(new \XoopsFormText(\_AM_WGGITHUB_DIRECTORY_NAME, 'dir_name', 50, 255, $this->getVar('dir_name')), true);
        // Form Editor DhtmlTextArea dirDescr
        $editorConfigs = [];
        if ($isAdmin) {
            $editor = $helper->getConfig('editor_admin');
        } else {
            $editor = $helper->getConfig('editor_user');
        }
        $editorConfigs['name'] = 'dir_descr';
        $editorConfigs['value'] = $this->getVar('dir_descr', 'e');
        $editorConfigs['rows'] = 5;
        $editorConfigs['cols'] = 40;
        $editorConfigs['width'] = '100%';
        $editorConfigs['height'] = '400px';
        $editorConfigs['editor'] = $editor;
        $form->addElement(new \XoopsFormEditor(\_AM_WGGITHUB_DIRECTORY_DESCR, 'dir_descr', $editorConfigs));
        // Form Select dirType
        $dirTypeSelect = new \XoopsFormSelect(\_AM_WGGITHUB_DIRECTORY_TYPE, 'dir_type', $this->getVar('dir_type'), 5);
        $dirTypeSelect->addOption(Constants::DIRECTORY_TYPE_USER, \_AM_WGGITHUB_DIRECTORY_TYPE_USER);
        $dirTypeSelect->addOption(Constants::DIRECTORY_TYPE_ORG, \_AM_WGGITHUB_DIRECTORY_TYPE_ORG);
        $form->addElement($dirTypeSelect, true);
        // Form Select dirContent
        $dirContentSelect = new \XoopsFormSelect(\_AM_WGGITHUB_DIRECTORY_CONTENT, 'dir_content', $this->getVar('dir_content'), 3);
        $dirContentSelect->addOption(Constants::DIRECTORY_CONTENT_ALL, \_AM_WGGITHUB_DIRECTORY_CONTENT_ALL);
        $dirContentSelect->addOption(Constants::DIRECTORY_CONTENT_OWN, \_AM_WGGITHUB_DIRECTORY_CONTENT_OWN);
        $form->addElement($dirContentSelect, true);
        // Form Radio Yes/No dirAutoupdate
        $dirAutoupdate = $this->isNew() ?: $this->getVar('dir_autoupdate');
        $form->addElement(new \XoopsFormRadioYN(\_AM_WGGITHUB_DIRECTORY_AUTOUPDATE, 'dir_autoupdate', $dirAutoupdate));
        // Form Radio Yes/No dirOnline
        $dirOnline = $this->isNew() ?: $this->getVar('dir_online');
        $form->addElement(new \XoopsFormRadioYN(\_AM_WGGITHUB_DIRECTORY_ONLINE, 'dir_online', $dirOnline));
        // Form Select dirFilterrelease
        $dirFilterrelease = $this->isNew() ?: $this->getVar('dir_filterrelease');
        $form->addElement(new \XoopsFormRadioYN(\_AM_WGGITHUB_DIRECTORY_FILTERRELEASE, 'dir_filterrelease', $dirFilterrelease));
        // Form Text dirWeight
        $dirWeight = $this->isNew() ? 0 : $this->getVar('dir_weight');
        $form->addElement(new \XoopsFormText(\_AM_WGGITHUB_DIRECTORY_WEIGHT, 'dir_weight', 50, 255, $dirWeight), true);
        // Form Text Date Select dirDatecreated
        $dirDatecreated = $this->isNew() ?: $this->getVar('dir_datecreated');
        $form->addElement(new \XoopsFormTextDateSelect(\_AM_WGGITHUB_DIRECTORY_DATECREATED, 'dir_datecreated', '', $dirDatecreated));
        // Form Select User dirSubmitter
        $form->addElement(new \XoopsFormSelectUser(\_AM_WGGITHUB_DIRECTORY_SUBMITTER, 'dir_submitter', false, $this->getVar('dir_submitter')));
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
    public function getValuesDirectories($keys = null, $format = null, $maxDepth = null)
    {
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id']        = $this->getVar('dir_id');
        $ret['name']      = $this->getVar('dir_name');
        $ret['descr']     = $this->getVar('dir_descr');
        $ret['type']      = $this->getVar('dir_type');
        $ret['type_text'] = Constants::DIRECTORY_TYPE_USER == $this->getVar('dir_type') ? \_AM_WGGITHUB_DIRECTORY_TYPE_USER : \_AM_WGGITHUB_DIRECTORY_TYPE_ORG;
        $content = $this->getVar('dir_content');
        $ret['content'] = $content;
        switch ($content) {
            case Constants::DIRECTORY_CONTENT_ALL:
            default:
                $content_text = \_AM_WGGITHUB_DIRECTORY_CONTENT_ALL;
                break;
            case Constants::DIRECTORY_CONTENT_OWN:
                $content_text = \_AM_WGGITHUB_DIRECTORY_CONTENT_OWN;
                break;
        }
        $ret['content_shorttext'] = Utility::truncateHtml($content_text);
        $ret['autoupdate']        = (int)$this->getVar('dir_autoupdate') > 0 ? _YES : _NO;
        $ret['online']            = (int)$this->getVar('dir_online') > 0 ? _YES : _NO;
        $ret['filterrelease']     = (int)$this->getVar('dir_filterrelease') > 0 ? _YES : _NO;
        $ret['weight']            = (int)$this->getVar('dir_weight');
        $ret['datecreated']       = \formatTimestamp($this->getVar('dir_datecreated'), 's');
        $ret['submitter']         = \XoopsUser::getUnameFromId($this->getVar('dir_submitter'));
        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArrayDirectories()
    {
        $ret = [];
        $vars = $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar('"{$var}"');
        }
        return $ret;
    }
}
