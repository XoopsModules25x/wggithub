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
use XoopsModules\Wggithub\{
    Constants,
    MDParser
};


/**
 * Class Object Handler Readmes
 */
class ReadmesHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wggithub_readmes', Readmes::class, 'rm_id', 'rm_name');
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
     * Get Count Readmes in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountReadmes($start = 0, $limit = 0, $sort = 'rm_id ASC, rm_name', $order = 'ASC')
    {
        $crCountReadmes = new \CriteriaCompo();
        $crCountReadmes = $this->getReadmesCriteria($crCountReadmes, $start, $limit, $sort, $order);
        return $this->getCount($crCountReadmes);
    }

    /**
     * Get All Readmes in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllReadmes($start = 0, $limit = 0, $sort = 'rm_id ASC, rm_name', $order = 'ASC')
    {
        $crAllReadmes = new \CriteriaCompo();
        $crAllReadmes = $this->getReadmesCriteria($crAllReadmes, $start, $limit, $sort, $order);
        return $this->getAll($crAllReadmes);
    }

    /**
     * Get Criteria Readmes
     * @param        $crReadmes
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    private function getReadmesCriteria($crReadmes, $start, $limit, $sort, $order)
    {
        $crReadmes->setStart($start);
        $crReadmes->setLimit($limit);
        $crReadmes->setSort($sort);
        $crReadmes->setOrder($order);
        return $crReadmes;
    }

    /**
     * Update table requests
     *
     * @return boolean
     */
    public function updateTableReadmes()
    {
        $helper = Wggithub\Helper::getInstance();
        $repositoriesHandler = $helper->getHandler('Repositories');
        $readmesHandler = $helper->getHandler('Readmes');

        $libRepositories = new Wggithub\Github\Repositories();

        $submitter = isset($GLOBALS['xoopsUser']) && \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar('uid') : 0;

        $repositoriesCount = $repositoriesHandler->getCount();
        if ($repositoriesCount > 0) {
            $repositoriesAll = $repositoriesHandler->getAll();
            foreach (\array_keys($repositoriesAll) as $i) {
                $repoId = $repositoriesAll[$i]->getVar('repo_id');
                $repoStatus = $repositoriesAll[$i]->getVar('repo_status');
                $crReadmes = new \CriteriaCompo();
                $crReadmes->add(new \Criteria('rm_repoid', $repoId));
                $readmesCount = $readmesHandler->getCount($crReadmes);
                if (Constants::STATUS_NEW === $repoStatus || Constants::STATUS_UPDATED === $repoStatus || 0 == $readmesCount) {
                    $readme = $libRepositories->getReadme($repositoriesAll[$i]->getVar('repo_user'), $repositoriesAll[$i]->getVar('repo_name'));
                    if ($readmesCount > 0) {
                        $readmesAll = $readmesHandler->getAll($crReadmes);
                        foreach (\array_keys($readmesAll) as $j) {
                            $rmId = $readmesAll[$j]->getVar('rm_id');
                        }
                        unset($crReadmes, $readmesAll);
                        $readmesObj = $readmesHandler->get($rmId);
                    } else {
                        $readmesObj = $readmesHandler->create();
                    }
                }
                if (\is_array($readme)) {
                    $readmesObj->setVar('rm_repoid', $repoId);
                    $readmesObj->setVar('rm_name', $readme['name']);
                    $readmesObj->setVar('rm_type', $readme['type']);
                    $readmesObj->setVar('rm_content', $readme['content']);
                    $readmesObj->setVar('rm_encoding', $readme['encoding']);
                    $readmesObj->setVar('rm_downloadurl', $readme['download_url']);
                    $readmesObj->setVar('rm_datecreated',time());
                    $readmesObj->setVar('rm_submitter', $submitter);
                    // Insert Data
                    if (!$readmesHandler->insert($readmesObj)) {
                        return false;
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
    public function updateReadmes($repoId, $userName, $repoName)
    {
        $helper = Wggithub\Helper::getInstance();
        $readmesHandler = $helper->getHandler('Readmes');

        $githubClient = new Wggithub\Github\GithubClient();

        $submitter = isset($GLOBALS['xoopsUser']) && \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar('uid') : 0;

        $readme = $githubClient->getReadme($userName, $repoName);
        if (false === $readme) {
            return false;
        }
        if (count($readme) > 0) {
            if (array_key_exists('message', $readme)) {
                // not readme found
                // must return true otherwise releases will not be loaded
                return true;
            }
            $rmId = 0;
            $crReadmes = new \CriteriaCompo();
            $crReadmes->add(new \Criteria('rm_repoid', $repoId));
            $readmesAll = $readmesHandler->getAll($crReadmes);
            foreach (\array_keys($readmesAll) as $j) {
                $rmId = $readmesAll[$j]->getVar('rm_id');
            }
            unset($crReadmes, $readmesAll);
            if ($rmId > 0) {
                $readmesObj = $readmesHandler->get($rmId);
            } else {
                $readmesObj = $readmesHandler->create();
            }
            $readmesObj->setVar('rm_repoid', $repoId);
            $readmesObj->setVar('rm_name', $readme['name']);
            $readmesObj->setVar('rm_type', $readme['type']);
            $readmesObj->setVar('rm_content', $readme['content']);
            $readmesObj->setVar('rm_encoding', $readme['encoding']);
            $readmesObj->setVar('rm_downloadurl', $readme['download_url']);
            $baseurl = \substr($readme['html_url'], 0, \strrpos($readme['html_url'], '/') + 1);
            $readmesObj->setVar('rm_baseurl', $baseurl);
            $readmesObj->setVar('rm_datecreated',time());
            $readmesObj->setVar('rm_submitter', $submitter);
            // Insert Data
            if (!$readmesHandler->insert($readmesObj)) {
                return false;
            }
        }

        return true;
    }

    /**
     * convert md file content into clean text
     *
     * @param $contentDecoded
     * @return string
     */
    public function convertMD($contentDecoded)
    {
        // parse MD file
        $Parsedown = new MDParser\Parsedown();
        $contentClean = $Parsedown->text($contentDecoded);

        return $contentClean;
    }

    /**
     * Update table repositories with readme information
     *
     * @return boolean
     */
    public function updateRepoReadme()
    {
        // update repo_readme
        $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('wggithub_repositories') . ' INNER JOIN ' . $GLOBALS['xoopsDB']->prefix('wggithub_readmes');
        $sql .= ' ON ' . $GLOBALS['xoopsDB']->prefix('wggithub_repositories') . '.repo_id = ' . $GLOBALS['xoopsDB']->prefix('wggithub_readmes') . '.rm_repoid ';
        $sql .= 'SET ' . $GLOBALS['xoopsDB']->prefix('wggithub_repositories') . '.repo_readme = 1 ';
        $sql .= 'WHERE (((' . $GLOBALS['xoopsDB']->prefix('wggithub_readmes') . '.rm_id)>0));';
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
    public function getFormFilterReadmes($action = false, $start = 0, $limit = 0)
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
        $fieldSelect->addOption('repo_name', _AM_WGGITHUB_README_REPOID);
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
