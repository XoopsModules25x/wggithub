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
// Request repo_id
$repoId = Request::getInt('repo_id');
switch ($op) {
	case 'list':
	default:
		// Define Stylesheet
		$GLOBALS['xoTheme']->addStylesheet($style, null);
		$start = Request::getInt('start', 0);
		$limit = Request::getInt('limit', $helper->getConfig('adminpager'));
		$templateMain = 'wggithub_admin_repositories.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('repositories.php'));
		$adminObject->addItemButton(_AM_WGGITHUB_ADD_REPOSITORY, 'repositories.php?op=new', 'add');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		$repositoriesCount = $repositoriesHandler->getCountRepositories();
		$repositoriesAll = $repositoriesHandler->getAllRepositories($start, $limit);
		$GLOBALS['xoopsTpl']->assign('repositories_count', $repositoriesCount);
		$GLOBALS['xoopsTpl']->assign('wggithub_url', WGGITHUB_URL);
		$GLOBALS['xoopsTpl']->assign('wggithub_upload_url', WGGITHUB_UPLOAD_URL);
		// Table view repositories
		if ($repositoriesCount > 0) {
			foreach (\array_keys($repositoriesAll) as $i) {
				$repository = $repositoriesAll[$i]->getValuesRepositories();
				$GLOBALS['xoopsTpl']->append('repositories_list', $repository);
				unset($repository);
			}
			// Display Navigation
			if ($repositoriesCount > $limit) {
				include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new \XoopsPageNav($repositoriesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
		} else {
			$GLOBALS['xoopsTpl']->assign('error', _AM_WGGITHUB_THEREARENT_REPOSITORIES);
		}
		break;
	case 'new':
		$templateMain = 'wggithub_admin_repositories.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('repositories.php'));
		$adminObject->addItemButton(_AM_WGGITHUB_REPOSITORIES_LIST, 'repositories.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Form Create
		$repositoriesObj = $repositoriesHandler->create();
		$form = $repositoriesObj->getFormRepositories();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'save':
		// Security Check
		if (!$GLOBALS['xoopsSecurity']->check()) {
			\redirect_header('repositories.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		if ($repoId > 0) {
			$repositoriesObj = $repositoriesHandler->get($repoId);
		} else {
			$repositoriesObj = $repositoriesHandler->create();
		}
		// Set Vars
		$repositoriesObj->setVar('repo_nodeid', Request::getString('repo_nodeid', ''));
		$repositoriesObj->setVar('repo_user', Request::getString('repo_user', ''));
		$repositoriesObj->setVar('repo_name', Request::getString('repo_name', ''));
		$repositoriesObj->setVar('repo_fullname', Request::getString('repo_fullname', ''));
		$repositoryCreatedatObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('repo_createdat'));
		$repositoriesObj->setVar('repo_createdat', $repositoryCreatedatObj->getTimestamp());
		$repositoryUpdatedatObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('repo_updatedat'));
		$repositoriesObj->setVar('repo_updatedat', $repositoryUpdatedatObj->getTimestamp());
		$repositoriesObj->setVar('repo_htmlurl', Request::getString('repo_htmlurl', ''));
        $repositoriesObj->setVar('repo_prerelease', Request::getInt('repo_prerelease', 0));
        $repositoriesObj->setVar('repo_release', Request::getInt('repo_release', 0));
		$repositoriesObj->setVar('repo_status', Request::getInt('repo_status', 0));
		$repositoryDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('repo_datecreated'));
		$repositoriesObj->setVar('repo_datecreated', $repositoryDatecreatedObj->getTimestamp());
		$repositoriesObj->setVar('repo_submitter', Request::getInt('repo_submitter', 0));
		// Insert Data
		if ($repositoriesHandler->insert($repositoriesObj)) {
			$newRepoId = $repositoriesObj->getNewInsertedIdRepositories();
			$permId = isset($_REQUEST['repo_id']) ? $repoId : $newRepoId;
			$grouppermHandler = \xoops_getHandler('groupperm');
			$mid = $GLOBALS['xoopsModule']->getVar('mid');
			// Permission to view_repositories
			$grouppermHandler->deleteByModule($mid, 'wggithub_view_repositories', $permId);
			if (isset($_POST['groups_view_repositories'])) {
				foreach ($_POST['groups_view_repositories'] as $onegroupId) {
					$grouppermHandler->addRight('wggithub_view_repositories', $permId, $onegroupId, $mid);
				}
			}
			// Permission to submit_repositories
			$grouppermHandler->deleteByModule($mid, 'wggithub_submit_repositories', $permId);
			if (isset($_POST['groups_submit_repositories'])) {
				foreach ($_POST['groups_submit_repositories'] as $onegroupId) {
					$grouppermHandler->addRight('wggithub_submit_repositories', $permId, $onegroupId, $mid);
				}
			}
			// Permission to approve_repositories
			$grouppermHandler->deleteByModule($mid, 'wggithub_approve_repositories', $permId);
			if (isset($_POST['groups_approve_repositories'])) {
				foreach ($_POST['groups_approve_repositories'] as $onegroupId) {
					$grouppermHandler->addRight('wggithub_approve_repositories', $permId, $onegroupId, $mid);
				}
			}
			\redirect_header('repositories.php?op=list', 2, _AM_WGGITHUB_FORM_OK);
		}
		// Get Form
		$GLOBALS['xoopsTpl']->assign('error', $repositoriesObj->getHtmlErrors());
		$form = $repositoriesObj->getFormRepositories();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'edit':
		$templateMain = 'wggithub_admin_repositories.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('repositories.php'));
		$adminObject->addItemButton(_AM_WGGITHUB_ADD_REPOSITORY, 'repositories.php?op=new', 'add');
		$adminObject->addItemButton(_AM_WGGITHUB_REPOSITORIES_LIST, 'repositories.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Get Form
		$repositoriesObj = $repositoriesHandler->get($repoId);
		$form = $repositoriesObj->getFormRepositories();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'delete':
		$templateMain = 'wggithub_admin_repositories.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('repositories.php'));
		$repositoriesObj = $repositoriesHandler->get($repoId);
		$repoName = $repositoriesObj->getVar('repo_name');
		if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
			if (!$GLOBALS['xoopsSecurity']->check()) {
				\redirect_header('repositories.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
			}
			if ($repositoriesHandler->delete($repositoriesObj)) {
				\redirect_header('repositories.php', 3, _AM_WGGITHUB_FORM_DELETE_OK);
			} else {
				$GLOBALS['xoopsTpl']->assign('error', $repositoriesObj->getHtmlErrors());
			}
		} else {
			$xoopsconfirm = new Common\XoopsConfirm(
				['ok' => 1, 'repo_id' => $repoId, 'op' => 'delete'],
				$_SERVER['REQUEST_URI'],
				\sprintf(_AM_WGGITHUB_FORM_SURE_DELETE, $repositoriesObj->getVar('repo_name')));
			$form = $xoopsconfirm->getFormXoopsConfirm();
			$GLOBALS['xoopsTpl']->assign('form', $form->render());
		}
		break;
}
require __DIR__ . '/footer.php';
