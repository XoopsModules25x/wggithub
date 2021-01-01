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

    /**
     * Update table repositories
     *
     * @param       $user
     * @param array $repos
     * @param bool  $updateAddtionals
     * @param int   $dirContent
     * @return int
     */
    public function updateTableRepositories($user, $repos = [], $updateAddtionals = true, $dirContent = 0)
    {
        $reposNb = 0;
        $helper = \XoopsModules\Wggithub\Helper::getInstance();
        $repositoriesHandler = $helper->getHandler('Repositories');

        $submitter = isset($GLOBALS['xoopsUser']) && \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar('uid') : 0;
        // add/update all items from table repositories
        foreach ($repos as $key => $repo) {
            $fork = (bool)$repo['fork'];
            if (Constants::DIRECTORY_CONTENT_ALL == $dirContent || false === $fork) {
                $crRepositories = new \CriteriaCompo();
                $crRepositories->add(new \Criteria('repo_nodeid', $repo['node_id']));
                $repoId = 0;
                $status = 0;
                $updatedAtOld = 0;
                $updatedAtNew = 0;
                $repositoriesAll = $repositoriesHandler->getAll($crRepositories);
                foreach (\array_keys($repositoriesAll) as $i) {
                    $repoId = $repositoriesAll[$i]->getVar('repo_id');
                    $updatedAtOld = $repositoriesAll[$i]->getVar('repo_updatedat');
                    $status = $repositoriesAll[$i]->getVar('repo_status');
                    $repositoriesObj = $repositoriesAll[$i];
                }
                if ($repoId > 0) {
                    if (is_string($repo['updated_at'])) {
                        $updatedAtNew = \strtotime($repo['updated_at']);
                    }
                    if ($updatedAtOld != Constants::STATUS_OFFLINE && $updatedAtOld != $updatedAtNew) {
                        $status = Constants::STATUS_UPDATED;
                    }
                } else {
                    $repositoriesObj = $repositoriesHandler->create();
                    $updatedAtNew = \strtotime($repo['updated_at']);
                    $status = Constants::STATUS_NEW;
                }
                if (Constants::STATUS_UPTODATE !== $status) {
                    // Set Vars
                    $repositoriesObj->setVar('repo_nodeid', $repo['node_id']);
                    $repositoriesObj->setVar('repo_user', $user);
                    $repositoriesObj->setVar('repo_name', $repo['name']);
                    $repositoriesObj->setVar('repo_fullname', $repo['full_name']);
                    if (is_string($repo['created_at'])) {
                        $createdAt = \strtotime($repo['created_at']);
                    }
                    $repositoriesObj->setVar('repo_createdat', $createdAt);
                    $repositoriesObj->setVar('repo_updatedat', $updatedAtNew);
                    $repositoriesObj->setVar('repo_htmlurl', $repo['html_url']);
                    $repositoriesObj->setVar('repo_status', $status);
                    $repositoriesObj->setVar('repo_datecreated', time());
                    $repositoriesObj->setVar('repo_submitter', $submitter);
                    // Insert Data
                    if ($repositoriesHandler->insert($repositoriesObj)) {
                        $newRepoId = $repositoriesObj->getNewInsertedIdRepositories();
                        if (0 == $repoId) {
                            $repoId = $newRepoId;
                        }
                        $reposNb++;
                        if ($updateAddtionals && (Constants::STATUS_NEW == $status || Constants::STATUS_UPDATED == $status)) {
                            // add/update table readmes
                            $helper->getHandler('Readmes')->updateReadmes($repoId, $user, $repo['name']);
                            // add/update table release
                            $helper->getHandler('Releases')->updateReleases($repoId, $user, $repo['name']);
                            // change status to updated
                            $repositoriesObj = $repositoriesHandler->get($repoId);
                            $repositoriesObj->setVar('repo_status', Constants::STATUS_UPTODATE);
                            $repositoriesHandler->insert($repositoriesObj, true);
                        }
                    } else {
                        return false;
                    }
                }
            }
        }

        return $reposNb;
    }
}
