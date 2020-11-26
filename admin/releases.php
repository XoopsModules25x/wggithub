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
// It recovered the value of argument op in URL$
$op = Request::getCmd('op', 'list');
// Request rel_id
$relId = Request::getInt('rel_id');
switch ($op) {
	case 'list':
	default:
		// Define Stylesheet
		$GLOBALS['xoTheme']->addStylesheet($style, null);
		$start = Request::getInt('start', 0);
		$limit = Request::getInt('limit', $helper->getConfig('adminpager'));
		$templateMain = 'wggithub_admin_releases.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('releases.php'));
		$adminObject->addItemButton(_AM_WGGITHUB_ADD_RELEASE, 'releases.php?op=new', 'add');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		$releasesCount = $releasesHandler->getCountReleases();
		$releasesAll = $releasesHandler->getAllReleases($start, $limit);
		$GLOBALS['xoopsTpl']->assign('releases_count', $releasesCount);
		$GLOBALS['xoopsTpl']->assign('wggithub_url', WGGITHUB_URL);
		$GLOBALS['xoopsTpl']->assign('wggithub_upload_url', WGGITHUB_UPLOAD_URL);
		// Table view releases
		if ($releasesCount > 0) {
			foreach (\array_keys($releasesAll) as $i) {
				$release = $releasesAll[$i]->getValuesReleases();
				$GLOBALS['xoopsTpl']->append('releases_list', $release);
				unset($release);
			}
			// Display Navigation
			if ($releasesCount > $limit) {
				include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new \XoopsPageNav($releasesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
		} else {
			$GLOBALS['xoopsTpl']->assign('error', _AM_WGGITHUB_THEREARENT_RELEASES);
		}
		break;
	case 'new':
		$templateMain = 'wggithub_admin_releases.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('releases.php'));
		$adminObject->addItemButton(_AM_WGGITHUB_RELEASES_LIST, 'releases.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Form Create
		$releasesObj = $releasesHandler->create();
		$form = $releasesObj->getFormReleases();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'save':
		// Security Check
		if (!$GLOBALS['xoopsSecurity']->check()) {
			\redirect_header('releases.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		if ($relId > 0) {
			$releasesObj = $releasesHandler->get($relId);
		} else {
			$releasesObj = $releasesHandler->create();
		}
		// Set Vars
		$releasesObj->setVar('rel_repoid', Request::getInt('rel_repoid', 0));
		$releasesObj->setVar('rel_type', Request::getInt('rel_type', 0));
		$releasesObj->setVar('rel_name', Request::getString('rel_name', ''));
		$releasePublishedatObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('rel_publishedat'));
		$releasesObj->setVar('rel_publishedat', $releasePublishedatObj->getTimestamp());
		$releasesObj->setVar('rel_tarballurl', Request::getString('rel_tarballurl', ''));
		$releasesObj->setVar('rel_zipballurl', Request::getString('rel_zipballurl', ''));
		$releaseDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('rel_datecreated'));
		$releasesObj->setVar('rel_datecreated', $releaseDatecreatedObj->getTimestamp());
		$releasesObj->setVar('rel_submitter', Request::getInt('rel_submitter', 0));
		// Insert Data
		if ($releasesHandler->insert($releasesObj)) {
			\redirect_header('releases.php?op=list', 2, _AM_WGGITHUB_FORM_OK);
		}
		// Get Form
		$GLOBALS['xoopsTpl']->assign('error', $releasesObj->getHtmlErrors());
		$form = $releasesObj->getFormReleases();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'edit':
		$templateMain = 'wggithub_admin_releases.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('releases.php'));
		$adminObject->addItemButton(_AM_WGGITHUB_ADD_RELEASE, 'releases.php?op=new', 'add');
		$adminObject->addItemButton(_AM_WGGITHUB_RELEASES_LIST, 'releases.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Get Form
		$releasesObj = $releasesHandler->get($relId);
		$form = $releasesObj->getFormReleases();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'delete':
		$templateMain = 'wggithub_admin_releases.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('releases.php'));
		$releasesObj = $releasesHandler->get($relId);
		$relName = $releasesObj->getVar('rel_name');
		if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
			if (!$GLOBALS['xoopsSecurity']->check()) {
				\redirect_header('releases.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
			}
			if ($releasesHandler->delete($releasesObj)) {
				\redirect_header('releases.php', 3, _AM_WGGITHUB_FORM_DELETE_OK);
			} else {
				$GLOBALS['xoopsTpl']->assign('error', $releasesObj->getHtmlErrors());
			}
		} else {
			$xoopsconfirm = new Common\XoopsConfirm(
				['ok' => 1, 'rel_id' => $relId, 'op' => 'delete'],
				$_SERVER['REQUEST_URI'],
				\sprintf(_AM_WGGITHUB_FORM_SURE_DELETE, $releasesObj->getVar('rel_name')));
			$form = $xoopsconfirm->getFormXoopsConfirm();
			$GLOBALS['xoopsTpl']->assign('form', $form->render());
		}
		break;
}
require __DIR__ . '/footer.php';
