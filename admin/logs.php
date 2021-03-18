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
$logId = Request::getInt('log_id');
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('adminpager'));
$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);

switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $templateMain = 'wggithub_admin_logs.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('logs.php'));
        $adminObject->addItemButton(\_AM_WGGITHUB_LOG_CLEAR, 'logs.php?op=clear', 'delete');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $logsCount = $logsHandler->getCountLogs();
        $logsAll = $logsHandler->getAllLogs($start, $limit);
        $GLOBALS['xoopsTpl']->assign('logs_count', $logsCount);
        $GLOBALS['xoopsTpl']->assign('wggithub_url', WGGITHUB_URL);
        $GLOBALS['xoopsTpl']->assign('wggithub_upload_url', WGGITHUB_UPLOAD_URL);
        // Table view logs
        if ($logsCount > 0) {
            foreach (\array_keys($logsAll) as $i) {
                $log = $logsAll[$i]->getValuesLogs();
                $GLOBALS['xoopsTpl']->append('logs_list', $log);
                unset($log);
            }
            // Display Navigation
            if ($logsCount > $limit) {
                include_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($logsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_AM_WGGITHUB_THEREARENT_LOGS);
        }
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('logs.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($logId > 0) {
            $logsObj = $logsHandler->get($logId);
        } else {
            $logsObj = $logsHandler->create();
        }
        // Set Vars
        $logsObj->setVar('log_type', Request::getInt('log_type', 0));
        $logsObj->setVar('log_details', Request::getString('log_details', ''));
        $logsObj->setVar('log_result', Request::getString('log_result', ''));
        $logDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('log_datecreated'));
        $logsObj->setVar('log_datecreated', $logDatecreatedObj->getTimestamp());
        $logsObj->setVar('log_submitter', Request::getInt('log_submitter', 0));
        // Insert Data
        if ($logsHandler->insert($logsObj)) {
            \redirect_header('logs.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 2, \_AM_WGGITHUB_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $logsObj->getHtmlErrors());
        $form = $logsObj->getFormLogs(false, $start, $limit);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wggithub_admin_logs.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('logs.php'));
        $adminObject->addItemButton(\_AM_WGGITHUB_LOGS_LIST, 'logs.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $logsObj = $logsHandler->get($logId);
        $form = $logsObj->getFormLogs(false, $start, $limit);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wggithub_admin_logs.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('logs.php'));
        $logsObj = $logsHandler->get($logId);
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('logs.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($logsHandler->delete($logsObj)) {
                \redirect_header('logs.php', 3, \_AM_WGGITHUB_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $logsObj->getHtmlErrors());
            }
        } else {
            $xoopsconfirm = new Common\XoopsConfirm(
                ['ok' => 1, 'log_id' => $logId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_AM_WGGITHUB_FORM_SURE_DELETE, $logsObj->getVar('log_details')));
            $form = $xoopsconfirm->getFormXoopsConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
    case 'clear':
        $templateMain = 'wggithub_admin_logs.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('logs.php'));
        $adminObject->addItemButton(\_AM_WGGITHUB_LOGS_LIST, 'logs.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('logs.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            $logsHandler->deleteAll(null, true);
            \redirect_header('logs.php', 3, \_AM_WGGITHUB_FORM_DELETE_OK);
        } else {
            $xoopsconfirm = new Common\XoopsConfirm(
                ['ok' => 1, 'op' => 'clear'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_AM_WGGITHUB_FORM_SURE_DELETEALL, 'wggithub_logs'));
            $form = $xoopsconfirm->getFormXoopsConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
