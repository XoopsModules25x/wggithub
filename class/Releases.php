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
 * Class Object Releases
 */
class Releases extends \XoopsObject
{
    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('rel_id', \XOBJ_DTYPE_INT);
        $this->initVar('rel_repoid', \XOBJ_DTYPE_INT);
        $this->initVar('rel_type', \XOBJ_DTYPE_INT);
        $this->initVar('rel_name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('rel_prerelease', \XOBJ_DTYPE_INT);
        $this->initVar('rel_publishedat', \XOBJ_DTYPE_INT);
        $this->initVar('rel_tarballurl', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('rel_zipballurl', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('rel_datecreated', \XOBJ_DTYPE_INT);
        $this->initVar('rel_submitter', \XOBJ_DTYPE_INT);
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
    public function getNewInsertedIdReleases()
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
    public function getFormReleases($action = false, $start = 0, $limit = 0)
    {
        $helper = \XoopsModules\Wggithub\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }

        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm(\_AM_WGGITHUB_RELEASE_EDIT, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Table repositories
        $repositoriesHandler = $helper->getHandler('Repositories');
        $rmRepoidSelect = new \XoopsFormSelect(\_AM_WGGITHUB_README_REPOID, 'rel_repoid', $this->getVar('rel_repoid'));
        $rmRepoidSelect->addOptionArray($repositoriesHandler->getList());
        $form->addElement($rmRepoidSelect);
        // Form Select relType
        $relTypeSelect = new \XoopsFormSelect(\_AM_WGGITHUB_RELEASE_TYPE, 'rel_type', $this->getVar('rel_type'));
        $relTypeSelect->addOption('file');
        $form->addElement($relTypeSelect);
        // Form Text relName
        $form->addElement(new \XoopsFormText(\_AM_WGGITHUB_RELEASE_NAME, 'rel_name', 50, 255, $this->getVar('rel_name')), true);
        // Form Radio Yes/No relPrerelease
        $relPrerelease = $this->isNew() ?: $this->getVar('rel_prerelease');
        $form->addElement(new \XoopsFormRadioYN(\_AM_WGGITHUB_RELEASE_PRERELEASE, 'rel_prerelease', $relPrerelease));
        // Form Text Date Select relPublishedat
        $relPublishedat = $this->isNew() ?: $this->getVar('rel_publishedat');
        $form->addElement(new \XoopsFormTextDateSelect(\_AM_WGGITHUB_RELEASE_PUBLISHEDAT, 'rel_publishedat', '', $relPublishedat));
        // Form Text relTarballurl
        $form->addElement(new \XoopsFormText(\_AM_WGGITHUB_RELEASE_TARBALLURL, 'rel_tarballurl', 50, 255, $this->getVar('rel_tarballurl')));
        // Form Text relZipballurl
        $form->addElement(new \XoopsFormText(\_AM_WGGITHUB_RELEASE_ZIPBALLURL, 'rel_zipballurl', 50, 255, $this->getVar('rel_zipballurl')));
        // Form Text Date Select relDatecreated
        $relDatecreated = $this->isNew() ?: $this->getVar('rel_datecreated');
        $form->addElement(new \XoopsFormTextDateSelect(\_AM_WGGITHUB_RELEASE_DATECREATED, 'rel_datecreated', '', $relDatecreated));
        // Form Select User relSubmitter
        $form->addElement(new \XoopsFormSelectUser(\_AM_WGGITHUB_RELEASE_SUBMITTER, 'rel_submitter', false, $this->getVar('rel_submitter')));
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
    public function getValuesReleases($keys = null, $format = null, $maxDepth = null)
    {
        $helper  = \XoopsModules\Wggithub\Helper::getInstance();
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id']          = $this->getVar('rel_id');
        $repositoriesHandler = $helper->getHandler('Repositories');
        $repositoriesObj = $repositoriesHandler->get($this->getVar('rel_repoid'));
        if (\is_object($repositoriesObj)) {
            $ret['repoid']        = $repositoriesObj->getVar('repo_name');
        } else {
            $ret['repoid']        = '*****missing repo_name*****';
        }
        $ret['type']        = $this->getVar('rel_type');
        $ret['name']        = $this->getVar('rel_name');
        $ret['prerelease']  = (int)$this->getVar('rel_prerelease') > 0 ? _YES : _NO;
        $ret['publishedat'] = \formatTimestamp($this->getVar('rel_publishedat'), 'm');
        $ret['tarballurl']  = $this->getVar('rel_tarballurl');
        $ret['zipballurl']  = $this->getVar('rel_zipballurl');
        $ret['datecreated'] = \formatTimestamp($this->getVar('rel_datecreated'), 'm');
        $ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('rel_submitter'));
        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArrayReleases()
    {
        $ret = [];
        $vars = $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar('"{$var}"');
        }
        return $ret;
    }
}
