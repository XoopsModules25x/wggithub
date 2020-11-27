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

require __DIR__ . '/header.php';

// Template Index
$templateMain = 'wggithub_admin_permissions.tpl';
$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('permissions.php'));

$op = Request::getCmd('op', 'global');

// Get Form
include_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';
\xoops_load('XoopsFormLoader');

$formTitle = \_AM_WGGITHUB_PERMISSIONS_GLOBAL;
$permName = 'wggithub_ac';
$permDesc = \_AM_WGGITHUB_PERMISSIONS_GLOBAL_DESC;
$globalPerms = [
    Constants::PERM_GLOBAL_VIEW => \_AM_WGGITHUB_PERMISSIONS_GLOBAL_VIEW,
    Constants::PERM_GLOBAL_READ => \_AM_WGGITHUB_PERMISSIONS_GLOBAL_READ,
    Constants::PERM_README_UPDATE => \_AM_WGGITHUB_PERMISSIONS_README_UPDATE,
];

$moduleId = $xoopsModule->getVar('mid');
$permForm = new \XoopsGroupPermForm($formTitle, $moduleId, $permName, $permDesc, 'admin/permissions.php');
$permFound = false;
if ('global' === $op) {
    foreach ($globalPerms as $gPermId => $gPermName) {
        $permForm->addItem($gPermId, $gPermName);
    }
    $GLOBALS['xoopsTpl']->assign('form', $permForm->render());
    $permFound = true;
}
unset($permForm);
if (true !== $permFound) {
    \redirect_header('permissions.php', 3, \_AM_WGGITHUB_NO_PERMISSIONS_SET);
    exit();
}

require __DIR__ . '/footer.php';
