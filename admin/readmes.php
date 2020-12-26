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
$op    = Request::getCmd('op', 'list');
$rmId  = Request::getInt('rm_id');
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('adminpager'));
$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);

switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $templateMain = 'wggithub_admin_readmes.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('readmes.php'));
        $adminObject->addItemButton(_AM_WGGITHUB_ADD_README, 'readmes.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $readmesCount = $readmesHandler->getCountReadmes();
        $readmesAll = $readmesHandler->getAllReadmes($start, $limit);
        $GLOBALS['xoopsTpl']->assign('readmes_count', $readmesCount);
        $GLOBALS['xoopsTpl']->assign('wggithub_url', WGGITHUB_URL);
        $GLOBALS['xoopsTpl']->assign('wggithub_upload_url', WGGITHUB_UPLOAD_URL);
        // Table view readmes
        if ($readmesCount > 0) {
            foreach (\array_keys($readmesAll) as $i) {
                $readme = $readmesAll[$i]->getValuesReadmes();
                $GLOBALS['xoopsTpl']->append('readmes_list', $readme);
                unset($readme);
            }
            // Display Navigation
            if ($readmesCount > $limit) {
                include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($readmesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', _AM_WGGITHUB_THEREARENT_READMES);
        }
        break;
    case 'new':
        $templateMain = 'wggithub_admin_readmes.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('readmes.php'));
        $adminObject->addItemButton(_AM_WGGITHUB_READMES_LIST, 'readmes.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $readmesObj = $readmesHandler->create();
        $form = $readmesObj->getFormReadmes(false, $start, $limit);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('readmes.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($rmId > 0) {
            $readmesObj = $readmesHandler->get($rmId);
        } else {
            $readmesObj = $readmesHandler->create();
        }
        // Set Vars
        $readmesObj->setVar('rm_repoid', Request::getInt('rm_repoid', 0));
        $readmesObj->setVar('rm_name', Request::getString('rm_name', ''));
        $readmesObj->setVar('rm_type', Request::getString('rm_type', ''));
        $readmesObj->setVar('rm_content', Request::getString('rm_content', ''));
        $readmesObj->setVar('rm_encoding', Request::getString('rm_encoding', ''));
        $readmesObj->setVar('rm_downloadurl', Request::getString('rm_downloadurl', ''));
        $readmeDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('rm_datecreated'));
        $readmesObj->setVar('rm_datecreated', $readmeDatecreatedObj->getTimestamp());
        $readmesObj->setVar('rm_submitter', Request::getInt('rm_submitter', 0));
        // Insert Data
        if ($readmesHandler->insert($readmesObj)) {
            \redirect_header('readmes.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 2, _AM_WGGITHUB_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $readmesObj->getHtmlErrors());
        $form = $readmesObj->getFormReadmes(false, $start, $limit);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wggithub_admin_readmes.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('readmes.php'));
        $adminObject->addItemButton(_AM_WGGITHUB_ADD_README, 'readmes.php?op=new', 'add');
        $adminObject->addItemButton(_AM_WGGITHUB_READMES_LIST, 'readmes.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $readmesObj = $readmesHandler->get($rmId);
        $form = $readmesObj->getFormReadmes(false, $start, $limit);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wggithub_admin_readmes.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('readmes.php'));
        $readmesObj = $readmesHandler->get($rmId);
        $rmName = $readmesObj->getVar('rm_name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('readmes.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($readmesHandler->delete($readmesObj)) {
                \redirect_header('readmes.php', 3, _AM_WGGITHUB_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $readmesObj->getHtmlErrors());
            }
        } else {
            $xoopsconfirm = new Common\XoopsConfirm(
                ['ok' => 1, 'rm_id' => $rmId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(_AM_WGGITHUB_FORM_SURE_DELETE, $readmesObj->getVar('rm_name')));
            $form = $xoopsconfirm->getFormXoopsConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
