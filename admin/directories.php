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
// Request dir_id
$dirId = Request::getInt('dir_id');
switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $start = Request::getInt('start', 0);
        $limit = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wggithub_admin_directories.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('directories.php'));
        $adminObject->addItemButton(_AM_WGGITHUB_ADD_DIRECTORY, 'directories.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $directoriesCount = $directoriesHandler->getCountDirectories();
        $directoriesAll = $directoriesHandler->getAllDirectories($start, $limit);
        $GLOBALS['xoopsTpl']->assign('directories_count', $directoriesCount);
        $GLOBALS['xoopsTpl']->assign('wggithub_url', WGGITHUB_URL);
        $GLOBALS['xoopsTpl']->assign('wggithub_upload_url', WGGITHUB_UPLOAD_URL);
        // Table view directories
        if ($directoriesCount > 0) {
            foreach (\array_keys($directoriesAll) as $i) {
                $directory = $directoriesAll[$i]->getValuesDirectories();
                $GLOBALS['xoopsTpl']->append('directories_list', $directory);
                unset($directory);
            }
            // Display Navigation
            if ($directoriesCount > $limit) {
                include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($directoriesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', _AM_WGGITHUB_THEREARENT_DIRECTORIES);
        }
        break;
    case 'new':
        $templateMain = 'wggithub_admin_directories.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('directories.php'));
        $adminObject->addItemButton(_AM_WGGITHUB_DIRECTORIES_LIST, 'directories.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $directoriesObj = $directoriesHandler->create();
        $form = $directoriesObj->getFormDirectories();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('directories.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($dirId > 0) {
            $directoriesObj = $directoriesHandler->get($dirId);
        } else {
            $directoriesObj = $directoriesHandler->create();
        }
        // Set Vars
        $directoriesObj->setVar('dir_name', Request::getString('dir_name', ''));
        $directoriesObj->setVar('dir_type', Request::getInt('dir_type', 0));
        $directoriesObj->setVar('dir_autoupdate', Request::getInt('dir_autoupdate', 0));
        $directoriesObj->setVar('dir_online', Request::getInt('dir_online', 0));
        $directoriesObj->setVar('dir_filterrelease', Request::getInt('dir_filterrelease', 0));
        $directoryDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('dir_datecreated'));
        $directoriesObj->setVar('dir_datecreated', $directoryDatecreatedObj->getTimestamp());
        $directoriesObj->setVar('dir_submitter', Request::getInt('dir_submitter', 0));
        // Insert Data
        if ($directoriesHandler->insert($directoriesObj)) {
            \redirect_header('directories.php?op=list', 2, _AM_WGGITHUB_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $directoriesObj->getHtmlErrors());
        $form = $directoriesObj->getFormDirectories();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wggithub_admin_directories.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('directories.php'));
        $adminObject->addItemButton(_AM_WGGITHUB_ADD_DIRECTORY, 'directories.php?op=new', 'add');
        $adminObject->addItemButton(_AM_WGGITHUB_DIRECTORIES_LIST, 'directories.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $directoriesObj = $directoriesHandler->get($dirId);
        $form = $directoriesObj->getFormDirectories();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wggithub_admin_directories.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('directories.php'));
        $directoriesObj = $directoriesHandler->get($dirId);
        $dirName = $directoriesObj->getVar('dir_name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('directories.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($directoriesHandler->delete($directoriesObj)) {
                \redirect_header('directories.php', 3, _AM_WGGITHUB_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $directoriesObj->getHtmlErrors());
            }
        } else {
            $xoopsconfirm = new Common\XoopsConfirm(
                ['ok' => 1, 'dir_id' => $dirId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(_AM_WGGITHUB_FORM_SURE_DELETE, $directoriesObj->getVar('dir_name')));
            $form = $xoopsconfirm->getFormXoopsConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
