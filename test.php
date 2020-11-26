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
    Github\Github,
    Github\Repositories,
    Github\Releases,
};

require __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wggithub_index.tpl';
include_once \XOOPS_ROOT_PATH . '/header.php';
// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
$keywords = [];
// 
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wggithub_url', WGGITHUB_URL);
//

$libRepositories = new Repositories();
$libReleases = new Releases();



$github = Github::getInstance();
$github->apiErrorLimit = false;
$github->apiErrorMisc = false;
$crRepositories = new \CriteriaCompo();
$crRepositories->add(new \Criteria('repo_user', 'XoopsThemes'));
$crRepositories->add(new \Criteria('repo_status', '1'));
//$crRepositories->setStart(0);
//$crRepositories->setLimit(48);
$repositoriesCount = $repositoriesHandler->getCount($crRepositories);
$repositoriesAll = $repositoriesHandler->getAll($crRepositories);
if ($repositoriesCount > 0) {
    // Get All Repositories
    foreach (\array_keys($repositoriesAll) as $i) {
        $repoId = $repositoriesAll[$i]->getVar('repo_id');
        $res = $helper->getHandler('Readmes')->updateReadmes($repoId, $repositoriesAll[$i]->getVar('repo_user'), $repositoriesAll[$i]->getVar('repo_name'));
        //$res = $helper->getHandler('Releases')->updateReleases($repoId, $repositoriesAll[$i]->getVar('repo_user'), $repositoriesAll[$i]->getVar('repo_name'));
        if ($res) {
            // change status to updated
            $repositoriesObj = $repositoriesHandler->get($repoId);
            $repositoriesObj->setVar('repo_status', Constants::STATUS_UPTODATE);
            $repositoriesHandler->insert($repositoriesObj, true);
        } else {
            echo "Error:" . $repositoriesAll[$i]->getVar('repo_user') . ' - ' . $repositoriesAll[$i]->getVar('repo_name');
        }
        if ($github->apiErrorLimit) {
            break;
        }
    }
}

//$releases = $libReleases->getReleases('XoopsModules25x', 'modulebuilder');
//var_dump($releases);

//$helper->getHandler('Readmes')->updateTableReadmes();
//$helper->getHandler('Releases')->updateTableReleases();


/*

$github = GitHub::getInstance();







$result = $libRepositories->getUserRepositories('ggoffy');
//$result = $github->readOrgRepositories('XoopsModules25x');
var_dump($result);


$githubLib = new Repositories();
$result = $githubLib->getOrgRepositories('XoopsModules25x');
var_dump($result);

$githubLib = new Releases();
$result = $githubLib->getLatestRelease('XoopsModules25x', 'contact', true);
var_dump($result);


$result = $libRepositories->getReadme('XoopsModules25x', 'wggallery');
var_dump($result);
*/

require __DIR__ . '/footer.php';
