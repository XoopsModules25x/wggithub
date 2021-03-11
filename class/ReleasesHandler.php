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
 * Class Object Handler Releases
 */
class ReleasesHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wggithub_releases', Releases::class, 'rel_id', 'rel_name');
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
     * Get Count Releases in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountReleases($start = 0, $limit = 0, $sort = 'rel_id ASC, rel_name', $order = 'ASC')
    {
        $crCountReleases = new \CriteriaCompo();
        $crCountReleases = $this->getReleasesCriteria($crCountReleases, $start, $limit, $sort, $order);
        return $this->getCount($crCountReleases);
    }

    /**
     * Get All Releases in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllReleases($start = 0, $limit = 0, $sort = 'rel_id ASC, rel_name', $order = 'ASC')
    {
        $crAllReleases = new \CriteriaCompo();
        $crAllReleases = $this->getReleasesCriteria($crAllReleases, $start, $limit, $sort, $order);
        return $this->getAll($crAllReleases);
    }

    /**
     * Get Criteria Releases
     * @param        $crReleases
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    private function getReleasesCriteria($crReleases, $start, $limit, $sort, $order)
    {
        $crReleases->setStart($start);
        $crReleases->setLimit($limit);
        $crReleases->setSort($sort);
        $crReleases->setOrder($order);
        return $crReleases;
    }

    /**
     * Update table requests
     *
     * @return boolean
     */
    public function updateTableReleases()
    {
        $helper = Wggithub\Helper::getInstance();
        $repositoriesHandler = $helper->getHandler('Repositories');
        $releasesHandler = $helper->getHandler('Releases');

        $githubClient = new Wggithub\Github\GithubClient();

        $submitter = isset($GLOBALS['xoopsUser']) && \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar('uid') : 0;

        $repositoriesCount = $repositoriesHandler->getCount();
        if ($repositoriesCount > 0) {
            $repositoriesAll = $repositoriesHandler->getAll();
            foreach (\array_keys($repositoriesAll) as $i) {
                $repoId = $repositoriesAll[$i]->getVar('repo_id');
                $repoStatus = $repositoriesAll[$i]->getVar('repo_status');
                $crReleases = new \CriteriaCompo();
                $crReleases->add(new \Criteria('rel_repoid', $repoId));
                $releasesCount = $releasesHandler->getCount($crReleases);
                if (Constants::STATUS_NEW === $repoStatus || Constants::STATUS_UPDATED === $repoStatus || 0 == $releasesCount) {
                    $ghReleases = $githubClient->getReleases($repositoriesAll[$i]->getVar('repo_user'), $repositoriesAll[$i]->getVar('repo_name'));
                    if ($releasesCount > 0) {
                        $sql = 'DELETE FROM `' . $GLOBALS['xoopsDB']->prefix('wggithub_releases') . '` WHERE `rel_repoid` = ' . $repoId;
                        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
                            return false;
                        }
                    }
                    unset($crReleases);
                }
                $first = true;
                $final = false;
                foreach ($ghReleases as $ghRelease) {
                    if ($first || (!$final && !(bool)$ghRelease['prerelease'])) {
                        // save first in any case and save first final version
                        $releasesObj = $releasesHandler->create();
                        $releasesObj->setVar('rel_repoid', $repoId);
                        $releasesObj->setVar('rel_type', $ghRelease['type']);
                        $releasesObj->setVar('rel_name', $ghRelease['name']);
                        $releasesObj->setVar('rel_prerelease', (true == (bool)$ghRelease['prerelease']));
                        $releasesObj->setVar('rel_publishedat', \strtotime($ghRelease['published_at']));
                        $releasesObj->setVar('rel_tarballurl', $ghRelease['tarball_url']);
                        $releasesObj->setVar('rel_zipballurl', $ghRelease['zipball_url']);
                        $releasesObj->setVar('rel_datecreated', time());
                        $releasesObj->setVar('rel_submitter', $submitter);
                        // Insert Data
                        if (!$releasesHandler->insert($releasesObj)) {
                            return false;
                        }
                    }
                    $first = false;
                    if (false === (bool)$ghRelease['prerelease']) {
                        $final = true;
                    }
                }
            }
        }

        return true;
    }

    /**
     * Update table requests
     *
     * @param $repoId
     * @param $userName
     * @param $repoName
     * @return boolean
     */
    public function updateReleases($repoId, $userName, $repoName)
    {
        $helper = Wggithub\Helper::getInstance();
        $repositoriesHandler = $helper->getHandler('Repositories');
        $releasesHandler = $helper->getHandler('Releases');

        $githubClient = new Wggithub\Github\GithubClient();

        $submitter = isset($GLOBALS['xoopsUser']) && \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar('uid') : 0;

        $ghReleases = $githubClient->getReleases($userName, $repoName);
        if (false === $ghReleases) {
            return false;
        }
        if (count($ghReleases) > 0) {
            if (array_key_exists('message', $ghReleases)) {
                // not readme found
                // must return true otherwise releases will not be loaded
                return true;
            }
            $sql = 'DELETE FROM `' . $GLOBALS['xoopsDB']->prefix('wggithub_releases') . '` WHERE `rel_repoid` = ' . $repoId;
            if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
                return false;
            }


            $first = true;
            $final = false;
            foreach ($ghReleases as $ghRelease) {
                if ($first || (!$final && !(bool)$ghRelease['prerelease'])) {
                    // save first in any case and save first final version
                    $releasesObj = $releasesHandler->create();
                    $releasesObj->setVar('rel_repoid', $repoId);
                    $releasesObj->setVar('rel_type', $ghRelease['type']);
                    $releasesObj->setVar('rel_name', $ghRelease['name']);
                    $releasesObj->setVar('rel_prerelease', (true == (bool)$ghRelease['prerelease']));
                    $releasesObj->setVar('rel_publishedat', \strtotime($ghRelease['published_at']));
                    $releasesObj->setVar('rel_tarballurl', $ghRelease['tarball_url']);
                    $releasesObj->setVar('rel_zipballurl', $ghRelease['zipball_url']);
                    $releasesObj->setVar('rel_datecreated', time());
                    $releasesObj->setVar('rel_submitter', $submitter);
                    // Insert Data
                    if (!$releasesHandler->insert($releasesObj)) {
                        return false;
                    }
                }
                $first = false;
                if (false === (bool)$ghRelease['prerelease']) {
                    $final = true;
                }
            }
        }

        return true;
    }

    /**
     * Update table repositories with release information
     *
     * @return boolean
     */
    public function updateRepoReleases()
    {
        // update repo_prerelease
        $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('wggithub_repositories') . ' INNER JOIN ' . $GLOBALS['xoopsDB']->prefix('wggithub_releases');
        $sql .= ' ON ' . $GLOBALS['xoopsDB']->prefix('wggithub_repositories') . '.repo_id = ' . $GLOBALS['xoopsDB']->prefix('wggithub_releases') . '.rel_repoid ';
        $sql .= 'SET ' . $GLOBALS['xoopsDB']->prefix('wggithub_repositories') . '.repo_prerelease = 1 ';
        $sql .= 'WHERE (((' . $GLOBALS['xoopsDB']->prefix('wggithub_releases') . '.rel_prerelease)=1));';
        $GLOBALS['xoopsDB']->queryF($sql);

        // update repo_release
        $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('wggithub_repositories') . ' INNER JOIN ' . $GLOBALS['xoopsDB']->prefix('wggithub_releases');
        $sql .= ' ON ' . $GLOBALS['xoopsDB']->prefix('wggithub_repositories') . '.repo_id = ' . $GLOBALS['xoopsDB']->prefix('wggithub_releases') . '.rel_repoid ';
        $sql .= 'SET ' . $GLOBALS['xoopsDB']->prefix('wggithub_repositories') . '.repo_release = 1 ';
        $sql .= 'WHERE (((' . $GLOBALS['xoopsDB']->prefix('wggithub_releases') . '.rel_prerelease)=0));';
        $GLOBALS['xoopsDB']->queryF($sql);

        return true;
    }

    /**
     * @public function getForm
     * @param bool $action
     * @param int  $start
     * @param int  $limit
     * @return \XoopsSimpleForm
     */
    public function getFormFilterReleases($action = false, $start = 0, $limit = 0)
    {
        $helper = \XoopsModules\Wggithub\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsSimpleForm('', 'formFilterAdmin', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        $filterTray = new \XoopsFormElementTray('', '&nbsp;');
        // Form Select field
        $fieldSelect = new \XoopsFormSelect(_AM_WGGITHUB_FILTER, 'filter_field', 0);
        $fieldSelect->addOption('', ' ');
        $fieldSelect->addOption('rel_name', _AM_WGGITHUB_RELEASE_NAME);
        $filterTray->addElement($fieldSelect, true);
        // Form Select operand
        $operandsSelect = new \XoopsFormSelect('', 'filter_operand', 0);
        $operandsSelect->addOption(Constants::FILTER_OPERAND_EQUAL, _AM_WGGITHUB_FILTER_OPERAND_EQUAL);
        $operandsSelect->addOption(Constants::FILTER_OPERAND_LIKE, _AM_WGGITHUB_FILTER_OPERAND_LIKE);
        $filterTray->addElement($operandsSelect);
        // Form Text value
        $filterTray->addElement(new \XoopsFormText('', 'filter_value', 20, 255, ''), true);
        $filterTray->addElement(new \XoopsFormButton('', 'confirm_submit', _SUBMIT, 'submit'));
        $form->addElement($filterTray);
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'filter'));
        $form->addElement(new \XoopsFormHidden('start', $start));
        $form->addElement(new \XoopsFormHidden('limit', $limit));

        return $form;
    }

}
