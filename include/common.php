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
if (!\defined('XOOPS_ICONS32_PATH')) {
    \define('XOOPS_ICONS32_PATH', \XOOPS_ROOT_PATH . '/Frameworks/moduleclasses/icons/32');
}
if (!\defined('XOOPS_ICONS32_URL')) {
    \define('XOOPS_ICONS32_URL', \XOOPS_URL . '/Frameworks/moduleclasses/icons/32');
}
\define('WGGITHUB_DIRNAME', 'wggithub');
\define('WGGITHUB_PATH', \XOOPS_ROOT_PATH . '/modules/' . WGGITHUB_DIRNAME);
\define('WGGITHUB_URL', \XOOPS_URL . '/modules/' . WGGITHUB_DIRNAME);
\define('WGGITHUB_ICONS_PATH', WGGITHUB_PATH . '/assets/icons');
\define('WGGITHUB_ICONS_URL', WGGITHUB_URL . '/assets/icons');
\define('WGGITHUB_IMAGE_PATH', WGGITHUB_PATH . '/assets/images');
\define('WGGITHUB_IMAGE_URL', WGGITHUB_URL . '/assets/images');
\define('WGGITHUB_UPLOAD_PATH', XOOPS_UPLOAD_PATH . '/' . WGGITHUB_DIRNAME);
\define('WGGITHUB_UPLOAD_URL', XOOPS_UPLOAD_URL . '/' . WGGITHUB_DIRNAME);
\define('WGGITHUB_UPLOAD_FILES_PATH', WGGITHUB_UPLOAD_PATH . '/files');
\define('WGGITHUB_UPLOAD_FILES_URL', WGGITHUB_UPLOAD_URL . '/files');
\define('WGGITHUB_UPLOAD_IMAGE_PATH', WGGITHUB_UPLOAD_PATH . '/images');
\define('WGGITHUB_UPLOAD_IMAGE_URL', WGGITHUB_UPLOAD_URL . '/images');
\define('WGGITHUB_UPLOAD_SHOTS_PATH', WGGITHUB_UPLOAD_PATH . '/images/shots');
\define('WGGITHUB_UPLOAD_SHOTS_URL', WGGITHUB_UPLOAD_URL . '/images/shots');
\define('WGGITHUB_ADMIN', WGGITHUB_URL . '/admin/index.php');
$localLogo = WGGITHUB_IMAGE_URL . '/tdmxoops_logo.png';
// Module Information
$copyright = "<a href='https://wedega.com' title='XOOPS on Wedega' target='_blank'><img src='" . $localLogo . "' alt='XOOPS on Wedega' /></a>";
include_once \XOOPS_ROOT_PATH . '/class/xoopsrequest.php';
include_once WGGITHUB_PATH . '/include/functions.php';
