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

$dirname       = \basename(\dirname(__DIR__));
$moduleHandler = \xoops_getHandler('module');
$xoopsModule   = XoopsModule::getByDirname($dirname);
$moduleInfo    = $moduleHandler->get($xoopsModule->getVar('mid'));
$sysPathIcon32 = $moduleInfo->getInfo('sysicons32');

$adminmenu[] = [
	'title' => _MI_WGGITHUB_ADMENU1,
	'link' => 'admin/index.php',
	'icon' => $sysPathIcon32.'/dashboard.png',
];
$adminmenu[] = [
	'title' => _MI_WGGITHUB_ADMENU2,
	'link' => 'admin/settings.php',
	'icon' => 'assets/icons/32/blank.gif',
];
$adminmenu[] = [
	'title' => _MI_WGGITHUB_ADMENU3,
	'link' => 'admin/directories.php',
	'icon' => 'assets/icons/32/blank.gif',
];
$adminmenu[] = [
	'title' => _MI_WGGITHUB_ADMENU4,
	'link' => 'admin/logs.php',
	'icon' => 'assets/icons/32/blank.gif',
];
$adminmenu[] = [
	'title' => _MI_WGGITHUB_ADMENU5,
	'link' => 'admin/repositories.php',
	'icon' => 'assets/icons/32/blank.gif',
];
$adminmenu[] = [
	'title' => _MI_WGGITHUB_ADMENU6,
	'link' => 'admin/readmes.php',
	'icon' => 'assets/icons/32/addlink.png',
];
$adminmenu[] = [
	'title' => _MI_WGGITHUB_ADMENU7,
	'link' => 'admin/releases.php',
	'icon' => 'assets/icons/32/blank.gif',
];
$adminmenu[] = [
	'title' => _MI_WGGITHUB_ADMENU8,
	'link' => 'admin/permissions.php',
	'icon' => $sysPathIcon32.'/permissions.png',
];
$adminmenu[] = [
	'title' => _MI_WGGITHUB_ADMENU9,
	'link' => 'admin/feedback.php',
	'icon' => $sysPathIcon32.'/mail_foward.png',
];
$adminmenu[] = [
	'title' => _MI_WGGITHUB_ABOUT,
	'link' => 'admin/about.php',
	'icon' => $sysPathIcon32.'/about.png',
];
