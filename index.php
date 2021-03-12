<?php
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

use Xmf\Request;
use XoopsModules\Wggithub;
use XoopsModules\Wggithub\{
    Constants,
    Helper,
    Github\GithubClient
};

require __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wggithub_index.tpl';
include_once \XOOPS_ROOT_PATH . '/header.php';

// Permissions
$permGlobalView = $permissionsHandler->getPermGlobalView();
if (!$permGlobalView) {
    $GLOBALS['xoopsTpl']->assign('error', _NOPERM);
    require __DIR__ . '/footer.php';
}
$permGlobalRead   = $permissionsHandler->getPermGlobalRead();
$permReadmeUpdate = $permissionsHandler->getPermReadmeUpdate();

$op            = Request::getCmd('op', 'list');
$filterRelease = Request::getString('release', 'any');
$filterSortby  = Request::getString('sortby', 'update');

$GLOBALS['xoopsTpl']->assign('release', $filterRelease);
$GLOBALS['xoopsTpl']->assign('sortby', $filterSortby);

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
$GLOBALS['xoTheme']->addStylesheet(WGGITHUB_URL . '/assets/css/tabs.css', null);
$keywords = [];
// 
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wggithub_url', WGGITHUB_URL);
$GLOBALS['xoopsTpl']->assign('wggithub_image_url', WGGITHUB_IMAGE_URL);
//
$GLOBALS['xoopsTpl']->assign('permReadmeUpdate', $permReadmeUpdate);
$GLOBALS['xoopsTpl']->assign('permGlobalRead', $permGlobalRead);

$dirStart = [];
$dirLimit = [];

switch ($op) {
    case 'show':
    case 'list':
    case 'apiexceed':
    default:
        //check number of directories with auto_update
        $crDirectories = new \CriteriaCompo();
        $crDirectories->add(new \Criteria('dir_autoupdate', 1));
        $directoriesCount = $directoriesHandler->getCount($crDirectories);
        if ($directoriesCount > 0) {
            //check number of API calls
            $lastUpdate = 0;
            $crLogs = new \CriteriaCompo();
            $crLogs->add(new \Criteria('log_datecreated', (time() - 3600), '>'));
            $logsCount = $logsHandler->getCount($crLogs);
            if ($permGlobalRead && $logsCount < 60 && 'list' == $op) {
                $githubClient = GithubClient::getInstance();
                $githubClient->executeUpdate();
            }
            unset($crLogs);
        }
        unset($crDirectories);
        $crLogs = new \CriteriaCompo();
        $crLogs->add(new \Criteria('log_type', Constants::LOG_TYPE_UPDATE_END));
        $crLogs->add(new \Criteria('log_result', 'OK'));
        $crLogs->setStart(0);
        $crLogs->setLimit(1);
        $crLogs->setSort('log_id');
        $crLogs->setOrder('DESC');
        $logsAll = $logsHandler->getAll($crLogs);
        foreach (\array_keys($logsAll) as $i) {
            $lastUpdate = $logsAll[$i]->getVar('log_datecreated');
            $GLOBALS['xoopsTpl']->assign('lastUpdate', \formatTimestamp($lastUpdate, 'm'));
        }
        unset($crLogs);
        $crLogs = new \CriteriaCompo();
        $crLogs->setStart(0);
        $crLogs->setLimit(1);
        $crLogs->setSort('log_id');
        $crLogs->setOrder('DESC');
        $logsAll = $logsHandler->getAll($crLogs);
        foreach (\array_keys($logsAll) as $i) {
            if ($lastUpdate < $logsAll[$i]->getVar('log_datecreated')) {
                if (\strpos($logsAll[$i]->getVar('log_result'), 'API rate limit exceeded') > 0) {
                    $GLOBALS['xoopsTpl']->assign('apiexceed', true);
                } else {
                    $GLOBALS['xoopsTpl']->assign('apierror', true);
                }
            }
        }
        unset($crLogs);

        $menu  = Request::getInt('menu', 0);

        $crDirectories = new \CriteriaCompo();
        $crDirectories->add(new \Criteria('dir_online', 1));
        $crDirectories->setSort('dir_weight ASC, dir_id');
        $crDirectories->setOrder('ASC');
        $directoriesCount = $directoriesHandler->getCount($crDirectories);
        $GLOBALS['xoopsTpl']->assign('directoriesCount', $directoriesCount);
        if ($directoriesCount > 0) {
            $directoriesAll = $directoriesHandler->getAll($crDirectories);
            // Get All Directories
            $directories = [];
            foreach (\array_keys($directoriesAll) as $i) {
                $directories[$i] = $directoriesAll[$i]->getValuesDirectories();
                $dirName = $directoriesAll[$i]->getVar('dir_name');
                $dirFilterRelease = (bool)$directoriesAll[$i]->getVar('dir_filterrelease');
                $repos = [];
                $crRepositories = new \CriteriaCompo();
                //first block/parentheses
                $crRepo1 = new CriteriaCompo();
                $crRepo1->add(new Criteria('repo_user', $dirName));
                $crRepositories->add($crRepo1);
                //second
                $crRepo2 = new CriteriaCompo();
                $crRepo2->add(new Criteria('repo_status', Constants::STATUS_UPDATED));
                $crRepo2->add(new Criteria('repo_status', Constants::STATUS_UPTODATE), 'OR');
                $crRepositories->add($crRepo2);
                $repositoriesCountTotal = $repositoriesHandler->getCount($crRepositories);
                //third
                if ('any' === $filterRelease && $dirFilterRelease) {
                    $crRepo3 = new CriteriaCompo();
                    $crRepo3->add(new Criteria('repo_prerelease', 1));
                    $crRepo3->add(new Criteria('repo_release', 1), 'OR');
                    $crRepositories->add($crRepo3);
                } elseif ('final' === $filterRelease && $dirFilterRelease) {
                    $crRepo3 = new CriteriaCompo();
                    $crRepo3->add(new Criteria('repo_release', 1));
                    $crRepositories->add($crRepo3);
                }
                $repositoriesCount = $repositoriesHandler->getCount($crRepositories);

                $dirId = Request::getInt('dirId', 0);
                $dirStart[$i] = 0;
                $dirLimit[$i] = $helper->getConfig('userpager');
                if ($i == $dirId) {
                    $dirStart[$i] = Request::getInt('start', 0);
                    $dirLimit[$i] = Request::getInt('limit', 0);
                }

                $crRepositories->setStart($dirStart[$i]);
                $crRepositories->setLimit($dirLimit[$i]);
                switch ($filterSortby) {
                    case 'name':
                    default:
                        $crRepositories->setSort('repo_name');
                        $crRepositories->setOrder('ASC');
                        break;
                    case 'update':
                        $crRepositories->setSort('repo_updatedat');
                        $crRepositories->setOrder('DESC');
                        break;
                }
                if ($repositoriesCount > 0) {
                    $repositoriesAll = $repositoriesHandler->getAll($crRepositories);
                    foreach (\array_keys($repositoriesAll) as $j) {
                        $repoId = $repositoriesAll[$j]->getVar('repo_id');
                        $repos[$j] = $repositoriesAll[$j]->getValuesRepositories();
                        $repos[$j]['readme'] = ['content_clean' => _MA_WGGITHUB_README_NOFILE];
                        if ($repositoriesAll[$j]->getVar('repo_readme') > 0) {
                            $crReadmes = new \CriteriaCompo();
                            $crReadmes->add(new \Criteria('rm_repoid', $repoId));
                            $readmesAll = $readmesHandler->getAll($crReadmes);
                            foreach ($readmesAll as $readme) {
                                $repos[$j]['readme'] = $readme->getValuesReadmes();
                            }
                            unset($crReadmes, $readmesAll);
                        }
                        if ($repositoriesAll[$j]->getVar('repo_prerelease') > 0 || $repositoriesAll[$j]->getVar('repo_release') > 0) {
                            //$repos[$j]['releases'] = [];
                            $crReleases = new \CriteriaCompo();
                            $crReleases->add(new \Criteria('rel_repoid', $repoId));
                            $releasesAll = $releasesHandler->getAll($crReleases);
                            foreach ($releasesAll as $release) {
                                $repos[$j]['releases'][] = $release->getValuesReleases();
                            }
                            unset($crReleases, $releasesAll);
                        }
                    }
                    unset($repositoriesAll);
                }
                unset($crRepo1, $crRepo2, $crRepo3, $crRepositories);
                if ($repositoriesCount === $repositoriesCountTotal) {
                    $directories[$i]['countRepos'] = str_replace(['%s', '%t'], [$dirName, $repositoriesCountTotal], _MA_WGGITHUB_REPOSITORIES_COUNT2);
                } else {
                    $directories[$i]['countRepos'] = str_replace(['%s', '%r', '%t'], [$dirName, $repositoriesCount, $repositoriesCountTotal], _MA_WGGITHUB_REPOSITORIES_COUNT1);
                }
                $directories[$i]['repos'] = $repos;
                $directories[$i]['previousRepos'] = $dirStart[$i] > 0;
                $directories[$i]['previousOp'] = '&amp;dirId=' . $i . '&amp;start=' . ($dirStart[$i] - $dirLimit[$i]) . '&amp;limit=' . $dirLimit[$i] . '&amp;release=' . $filterRelease . '&amp;sortby=' . $filterSortby;
                $directories[$i]['nextRepos'] = ($repositoriesCount - $dirStart[$i]) > $limit;
                $directories[$i]['nextOp'] = '&amp;dirId=' . $i . '&amp;start=' . ($dirStart[$i] + $dirLimit[$i]) . '&amp;limit=' . $dirLimit[$i] . '&amp;release=' . $filterRelease . '&amp;sortby=' . $filterSortby;
                $GLOBALS['xoopsTpl']->assign('menu', $menu);
                $GLOBALS['xoopsTpl']->assign('directories', $directories);
            }

            unset($crDirectories, $directories);

            $GLOBALS['xoopsTpl']->assign('lang_thereare', \sprintf(\_MA_WGGITHUB_INDEX_THEREARE, $directoriesCount));
            $GLOBALS['xoopsTpl']->assign('divideby', $helper->getConfig('divideby'));
            $GLOBALS['xoopsTpl']->assign('numb_col', $helper->getConfig('numb_col'));
        }

        break;
    case 'update_dir':
        // Permissions
        if (!$permGlobalRead) {
            $GLOBALS['xoopsTpl']->assign('error', \_NOPERM);
            require __DIR__ . '/footer.php';
        }
        $dirName = Request::getString('dir_name', '');
        $redir   = 'index.php?op=list_afterupdate&amp;release=' . $filterRelease . '&amp;sortby=' . $filterSortby;
        $githubClient = GithubClient::getInstance();
        $result = $githubClient->executeUpdate($dirName);
        if ($result) {
            \redirect_header($redir, 2, \_MA_WGGITHUB_READGH_SUCCESS);
        } else {
            \redirect_header($redir, 2, \_MA_WGGITHUB_READGH_ERROR_API);
        }

        break;
    case 'update_readme':
        // Permissions
        if (!$permReadmeUpdate) {
            $GLOBALS['xoopsTpl']->assign('error', \_NOPERM);
            require __DIR__ . '/footer.php';
        }
        $repoId   = Request::getInt('repo_id', 0);
        $repoUser = Request::getString('repo_user', 'none');
        $repoName = Request::getString('repo_name', 'none');
        $redir    = 'index.php?op=list_afterupdate&amp;release=' . $filterRelease . '&amp;sortby=' . $filterSortby;
        $result = $helper->getHandler('Readmes')->updateReadmes($repoId, $repoUser, $repoName);
        if ($result) {
            \redirect_header($redir, 2, \_MA_WGGITHUB_READGH_SUCCESS);
        } else {
            \redirect_header($redir, 2, \_MA_WGGITHUB_READGH_ERROR_API);
        }
        break;
}

$GLOBALS['xoopsTpl']->assign('table_type', $helper->getConfig('table_type'));
// Breadcrumbs
$xoBreadcrumbs[] = ['title' => \_MA_WGGITHUB_INDEX];
// Keywords
wggithubMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);
// Description
wggithubMetaDescription(\_MA_WGGITHUB_INDEX_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGGITHUB_URL.'/index.php');
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wggithub_upload_url', WGGITHUB_UPLOAD_URL);
require __DIR__ . '/footer.php';
