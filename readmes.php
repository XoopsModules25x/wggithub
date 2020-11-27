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
use XoopsModules\Wggithub\Constants;
use XoopsModules\Wggithub\Common;

require __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wggithub_readmes.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';

$op    = Request::getCmd('op', 'list');
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('userpager'));
$rmId = Request::getInt('rm_id', 0);

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);

$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wggithub_url', WGGITHUB_URL);

$keywords = [];

$GLOBALS['xoopsTpl']->assign('showItem', $rmId > 0);

switch ($op) {
	case 'show':
	case 'list':
	default:
		$crReadmes = new \CriteriaCompo();
		if ($rmId > 0) {
			$crReadmes->add(new \Criteria('rm_id', $rmId));
		}
		$readmesCount = $readmesHandler->getCount($crReadmes);
		$GLOBALS['xoopsTpl']->assign('readmesCount', $readmesCount);
		$crReadmes->setStart($start);
		$crReadmes->setLimit($limit);
		$readmesAll = $readmesHandler->getAll($crReadmes);
		if ($readmesCount > 0) {
			$readmes = [];
			// Get All Readmes
			foreach (\array_keys($readmesAll) as $i) {
				$readmes[$i] = $readmesAll[$i]->getValuesReadmes();
				$keywords[$i] = $readmesAll[$i]->getVar('rm_name');
			}
			$GLOBALS['xoopsTpl']->assign('readmes', $readmes);
			unset($readmes);
			// Display Navigation
			if ($readmesCount > $limit) {
				include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new \XoopsPageNav($readmesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
			$GLOBALS['xoopsTpl']->assign('type', $helper->getConfig('table_type'));
			$GLOBALS['xoopsTpl']->assign('divideby', $helper->getConfig('divideby'));
			$GLOBALS['xoopsTpl']->assign('numb_col', $helper->getConfig('numb_col'));
		}
		break;
}

// Breadcrumbs
$xoBreadcrumbs[] = ['title' => _MA_WGGITHUB_READMES];

// Keywords
wggithubMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

// Description
wggithubMetaDescription(_MA_WGGITHUB_READMES_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGGITHUB_URL.'/readmes.php');
$GLOBALS['xoopsTpl']->assign('wggithub_upload_url', WGGITHUB_UPLOAD_URL);

require __DIR__ . '/footer.php';
