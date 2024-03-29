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

\defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Repositories
 */
class Repositories extends \XoopsObject
{
    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('repo_id', \XOBJ_DTYPE_INT);
        $this->initVar('repo_nodeid', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('repo_user', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('repo_name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('repo_fullname', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('repo_createdat', \XOBJ_DTYPE_INT);
        $this->initVar('repo_updatedat', \XOBJ_DTYPE_INT);
        $this->initVar('repo_htmlurl', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('repo_readme', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('repo_prerelease', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('repo_release', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('repo_approved', \XOBJ_DTYPE_INT);
        $this->initVar('repo_status', \XOBJ_DTYPE_INT);
        $this->initVar('repo_datecreated', \XOBJ_DTYPE_INT);
        $this->initVar('repo_submitter', \XOBJ_DTYPE_INT);
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
    public function getNewInsertedIdRepositories()
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
    public function getFormRepositories($action = false, $start = 0, $limit = 0)
    {
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }

        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm(\_AM_WGGITHUB_REPOSITORY_EDIT, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Text repoNodeid
        $form->addElement(new \XoopsFormText(\_AM_WGGITHUB_REPOSITORY_NODEID, 'repo_nodeid', 50, 255, $this->getVar('repo_nodeid')));
        // Form Text repoUser
        $form->addElement(new \XoopsFormText(\_AM_WGGITHUB_REPOSITORY_USER, 'repo_user', 50, 255, $this->getVar('repo_user')), true);
        // Form Text repoName
        $form->addElement(new \XoopsFormText(\_AM_WGGITHUB_REPOSITORY_NAME, 'repo_name', 50, 255, $this->getVar('repo_name')), true);
        // Form Text repoFullname
        $form->addElement(new \XoopsFormText(\_AM_WGGITHUB_REPOSITORY_FULLNAME, 'repo_fullname', 50, 255, $this->getVar('repo_fullname')));
        // Form Text Date Select repoCreatedat
        $repoCreatedat = $this->isNew() ?: $this->getVar('repo_createdat');
        $form->addElement(new \XoopsFormTextDateSelect(\_AM_WGGITHUB_REPOSITORY_CREATEDAT, 'repo_createdat', '', $repoCreatedat));
        // Form Text Date Select repoUpdatedat
        $repoUpdatedat = $this->isNew() ?: $this->getVar('repo_updatedat');
        $form->addElement(new \XoopsFormTextDateSelect(\_AM_WGGITHUB_REPOSITORY_UPDATEDAT, 'repo_updatedat', '', $repoUpdatedat));
        // Form Text repoHtmlurl
        $form->addElement(new \XoopsFormText(\_AM_WGGITHUB_REPOSITORY_HTMLURL, 'repo_htmlurl', 50, 255, $this->getVar('repo_htmlurl')));
        // Form Text repoReadme
        $form->addElement(new \XoopsFormText(\_AM_WGGITHUB_REPOSITORY_README, 'repo_readme', 50, 255, $this->getVar('repo_readme')));
        // Form Text repoPrerelease
        $form->addElement(new \XoopsFormText(\_AM_WGGITHUB_REPOSITORY_PRERELEASE, 'repo_prerelease', 50, 255, $this->getVar('repo_prerelease')));
        // Form Text repoRelease
        $form->addElement(new \XoopsFormText(\_AM_WGGITHUB_REPOSITORY_RELEASE, 'repo_release', 50, 255, $this->getVar('repo_prelease')));
        // Form Radio Yes/No repoApproved
        $repoApproved = $this->isNew() ?: $this->getVar('repo_approved');
        $form->addElement(new \XoopsFormRadioYN(\_AM_WGGITHUB_REPOSITORY_APPROVED, 'repo_approved', $repoApproved));
        // Form Select Status repoStatus
        $repoStatusSelect = new \XoopsFormSelect(\_AM_WGGITHUB_REPOSITORY_STATUS, 'repo_status', $this->getVar('repo_status'));
        $repoStatusSelect->addOption(Constants::STATUS_NONE, \_AM_WGGITHUB_STATUS_NONE);
        $repoStatusSelect->addOption(Constants::STATUS_UPTODATE, \_AM_WGGITHUB_STATUS_UPTODATE);
        $repoStatusSelect->addOption(Constants::STATUS_UPDATED, \_AM_WGGITHUB_STATUS_UPDATED);
        $repoStatusSelect->addOption(Constants::STATUS_OFFLINE, \_AM_WGGITHUB_STATUS_OFFLINE);
        $form->addElement($repoStatusSelect);
        // Form Text Date Select repoDatecreated
        $repoDatecreated = $this->isNew() ?: $this->getVar('repo_datecreated');
        $form->addElement(new \XoopsFormTextDateSelect(\_AM_WGGITHUB_REPOSITORY_DATECREATED, 'repo_datecreated', '', $repoDatecreated));
        // Form Select User repoSubmitter
        $form->addElement(new \XoopsFormSelectUser(\_AM_WGGITHUB_REPOSITORY_SUBMITTER, 'repo_submitter', false, $this->getVar('repo_submitter')));
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
    public function getValuesRepositories($keys = null, $format = null, $maxDepth = null)
    {
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id']          = $this->getVar('repo_id');
        $ret['nodeid']      = $this->getVar('repo_nodeid');
        $ret['user']        = $this->getVar('repo_user');
        $ret['name']        = $this->getVar('repo_name');
        $ret['fullname']    = $this->getVar('repo_fullname');
        $ret['createdat']   = \formatTimestamp($this->getVar('repo_createdat'), 'm');
        $ret['updatedat']   = \formatTimestamp($this->getVar('repo_updatedat'), 'm');
        $ret['htmlurl']     = $this->getVar('repo_htmlurl');
        $ret['readme']      = $this->getVar('repo_readme');
        $ret['prerelease']  = $this->getVar('repo_prerelease');
        $ret['release']     = $this->getVar('repo_release');
        $ret['approved']    = (int)$this->getVar('repo_approved') > 0 ? \_YES : \_NO;
        $status             = $this->getVar('repo_status');
        $ret['status']      = $status;
        switch ($status) {
            case Constants::STATUS_NONE:
            default:
                $status_text = \_AM_WGGITHUB_STATUS_NONE;
                break;
            case Constants::STATUS_NEW:
                $status_text = \_AM_WGGITHUB_STATUS_NEW;
                break;
            case Constants::STATUS_UPTODATE:
                $status_text = \_AM_WGGITHUB_STATUS_UPTODATE;
                break;
            case Constants::STATUS_UPDATED:
                $status_text = \_AM_WGGITHUB_STATUS_UPDATED;
                break;
            case Constants::STATUS_OFFLINE:
                $status_text = \_AM_WGGITHUB_STATUS_OFFLINE;
                break;
        }
        $ret['status_text'] = $status_text;
        $ret['datecreated'] = \formatTimestamp($this->getVar('repo_datecreated'), 'm');
        $ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('repo_submitter'));
        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArrayRepositories()
    {
        $ret = [];
        $vars = $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar('"{$var}"');
        }
        return $ret;
    }
}
