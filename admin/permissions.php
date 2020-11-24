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

// Template Index
$templateMain = 'wggithub_admin_permissions.tpl';
$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('permissions.php'));

$op = Request::getCmd('op', 'global');

// Get Form
include_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';
\xoops_load('XoopsFormLoader');
$permTableForm = new \XoopsSimpleForm('', 'fselperm', 'permissions.php', 'post');
$formSelect = new \XoopsFormSelect('', 'op', $op);
$formSelect->setExtra('onchange="document.fselperm.submit()"');
$formSelect->addOption('global', _AM_WGGITHUB_PERMISSIONS_GLOBAL);
$formSelect->addOption('approve_repositories', _AM_WGGITHUB_PERMISSIONS_APPROVE . ' Repositories');
$formSelect->addOption('submit_repositories', _AM_WGGITHUB_PERMISSIONS_SUBMIT . ' Repositories');
$formSelect->addOption('view_repositories', _AM_WGGITHUB_PERMISSIONS_VIEW . ' Repositories');
$formSelect->addOption('approve_directories', _AM_WGGITHUB_PERMISSIONS_APPROVE . ' Directories');
$formSelect->addOption('submit_directories', _AM_WGGITHUB_PERMISSIONS_SUBMIT . ' Directories');
$formSelect->addOption('view_directories', _AM_WGGITHUB_PERMISSIONS_VIEW . ' Directories');
$permTableForm->addElement($formSelect);
$permTableForm->display();
switch ($op) {
	case 'global':
	default:
		$formTitle = _AM_WGGITHUB_PERMISSIONS_GLOBAL;
		$permName = 'wggithub_ac';
		$permDesc = _AM_WGGITHUB_PERMISSIONS_GLOBAL_DESC;
		$globalPerms = array( '4' => _AM_WGGITHUB_PERMISSIONS_GLOBAL_4, '8' => _AM_WGGITHUB_PERMISSIONS_GLOBAL_8, '16' => _AM_WGGITHUB_PERMISSIONS_GLOBAL_16 );
		break;
	case 'approve_repositories':
		$formTitle = _AM_WGGITHUB_PERMISSIONS_APPROVE;
		$permName = 'wggithub_approve_repositories';
		$permDesc = _AM_WGGITHUB_PERMISSIONS_APPROVE_DESC . ' Repositories';
		$handler = $helper->getHandler('repositories');
		break;
	case 'submit_repositories':
		$formTitle = _AM_WGGITHUB_PERMISSIONS_SUBMIT;
		$permName = 'wggithub_submit_repositories';
		$permDesc = _AM_WGGITHUB_PERMISSIONS_SUBMIT_DESC . ' Repositories';
		$handler = $helper->getHandler('repositories');
		break;
	case 'view_repositories':
		$formTitle = _AM_WGGITHUB_PERMISSIONS_VIEW;
		$permName = 'wggithub_view_repositories';
		$permDesc = _AM_WGGITHUB_PERMISSIONS_VIEW_DESC . ' Repositories';
		$handler = $helper->getHandler('repositories');
		break;
	case 'approve_directories':
		$formTitle = _AM_WGGITHUB_PERMISSIONS_APPROVE;
		$permName = 'wggithub_approve_directories';
		$permDesc = _AM_WGGITHUB_PERMISSIONS_APPROVE_DESC . ' Directories';
		$handler = $helper->getHandler('directories');
		break;
	case 'submit_directories':
		$formTitle = _AM_WGGITHUB_PERMISSIONS_SUBMIT;
		$permName = 'wggithub_submit_directories';
		$permDesc = _AM_WGGITHUB_PERMISSIONS_SUBMIT_DESC . ' Directories';
		$handler = $helper->getHandler('directories');
		break;
	case 'view_directories':
		$formTitle = _AM_WGGITHUB_PERMISSIONS_VIEW;
		$permName = 'wggithub_view_directories';
		$permDesc = _AM_WGGITHUB_PERMISSIONS_VIEW_DESC . ' Directories';
		$handler = $helper->getHandler('directories');
		break;
}
$moduleId = $xoopsModule->getVar('mid');
$permform = new \XoopsGroupPermForm($formTitle, $moduleId, $permName, $permDesc, 'admin/permissions.php');
$permFound = false;
if ('global' === $op) {
	foreach ($globalPerms as $gPermId => $gPermName) {
		$permform->addItem($gPermId, $gPermName);
	}
	$GLOBALS['xoopsTpl']->assign('form', $permform->render());
	$permFound = true;
}
if ($op === 'approve_repositories' || $op === 'submit_repositories' || $op === 'view_repositories') {
	$repositoriesCount = $repositoriesHandler->getCountRepositories();
	if ($repositoriesCount > 0) {
		$repositoriesAll = $repositoriesHandler->getAllRepositories(0, 'repo_name');
		foreach (\array_keys($repositoriesAll) as $i) {
			$permform->addItem($repositoriesAll[$i]->getVar('repo_id'), $repositoriesAll[$i]->getVar('repo_name'));
		}
		$GLOBALS['xoopsTpl']->assign('form', $permform->render());
	}
	$permFound = true;
}
if ($op === 'approve_directories' || $op === 'submit_directories' || $op === 'view_directories') {
	$directoriesCount = $directoriesHandler->getCountDirectories();
	if ($directoriesCount > 0) {
		$directoriesAll = $directoriesHandler->getAllDirectories(0, 'dir_name');
		foreach (\array_keys($directoriesAll) as $i) {
			$permform->addItem($directoriesAll[$i]->getVar('dir_id'), $directoriesAll[$i]->getVar('dir_name'));
		}
		$GLOBALS['xoopsTpl']->assign('form', $permform->render());
	}
	$permFound = true;
}
unset($permform);
if (true !== $permFound) {
	\redirect_header('permissions.php', 3, _AM_WGGITHUB_NO_PERMISSIONS_SET);
	exit();
}
require __DIR__ . '/footer.php';
