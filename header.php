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

include \dirname(__DIR__, 2) . '/mainfile.php';
include __DIR__ . '/include/common.php';
$moduleDirName = \basename(__DIR__);
// Breadcrumbs
$xoBreadcrumbs = [];
$xoBreadcrumbs[] = ['title' => \_MA_WGGITHUB_TITLE, 'link' => WGGITHUB_URL . '/'];
// Get instance of module
$helper = \XoopsModules\Wggithub\Helper::getInstance();
$settingsHandler = $helper->getHandler('Settings');
$repositoriesHandler = $helper->getHandler('Repositories');
$directoriesHandler = $helper->getHandler('Directories');
$logsHandler = $helper->getHandler('Logs');
$readmesHandler = $helper->getHandler('Readmes');
$releasesHandler = $helper->getHandler('Releases');
$permissionsHandler = $helper->getHandler('Permissions');
// 
$myts = MyTextSanitizer::getInstance();
// Default Css Style
$style = WGGITHUB_URL . '/assets/css/style.css';
// Smarty Default
$sysPathIcon16 = $GLOBALS['xoopsModule']->getInfo('sysicons16');
$sysPathIcon32 = $GLOBALS['xoopsModule']->getInfo('sysicons32');
$pathModuleAdmin = $GLOBALS['xoopsModule']->getInfo('dirmoduleadmin');
$modPathIcon16 = $GLOBALS['xoopsModule']->getInfo('modicons16');
$modPathIcon32 = $GLOBALS['xoopsModule']->getInfo('modicons16');
// Load Languages
\xoops_loadLanguage('main');
\xoops_loadLanguage('modinfo');
