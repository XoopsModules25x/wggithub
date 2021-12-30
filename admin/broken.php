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
 * @author         TDM XOOPS - Email:<goffy@wedega.com> - Website:<https://wedega.com>
 */

use Xmf\Request;
use XoopsModules\Wggithub;
use XoopsModules\Wggithub\Constants;

require __DIR__ . '/header.php';

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
$templateMain = 'wggithub_admin_broken.tpl';
$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('broken.php'));

// Check table repositories
$start = Request::getInt('startRepositories', 0);
$limit = Request::getInt('limitRepositories', $helper->getConfig('adminpager'));
$crRepositories = new \CriteriaCompo();
$crRepositories->add(new \Criteria('repo_status', Constants::STATUS_BROKEN));
$repositoriesCount = $repositoriesHandler->getCount($crRepositories);
$GLOBALS['xoopsTpl']->assign('repositories_count', $repositoriesCount);
$GLOBALS['xoopsTpl']->assign('repositories_result', \sprintf(\_AM_WGGITHUB_BROKEN_RESULT, 'Repositories'));
$crRepositories->setStart($start);
$crRepositories->setLimit($limit);
if ($repositoriesCount > 0) {
	$repositoriesAll = $repositoriesHandler->getAll($crRepositories);
	foreach (\array_keys($repositoriesAll) as $i) {
		$repository['table'] = 'Repositories';
		$repository['key'] = 'repo_id';
		$repository['keyval'] = $repositoriesAll[$i]->getVar('repo_id');
		$repository['main'] = $repositoriesAll[$i]->getVar('repo_name');
		$GLOBALS['xoopsTpl']->append('repositories_list', $repository);
	}
	// Display Navigation
	if ($repositoriesCount > $limit) {
		include_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
		$pagenav = new \XoopsPageNav($repositoriesCount, $limit, $start, 'startRepositories', 'op=list&limitRepositories=' . $limit);
		$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
	}
} else {
	$GLOBALS['xoopsTpl']->assign('nodataRepositories', \sprintf(\_AM_WGGITHUB_BROKEN_NODATA, 'Repositories'));
}
unset($crRepositories);

require __DIR__ . '/footer.php';
