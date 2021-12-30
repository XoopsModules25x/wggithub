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
use XoopsModules\Wggithub\Common;

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getCmd('op', 'list');
// Request req_id
$reqId = Request::getInt('req_id');
switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $start = Request::getInt('start', 0);
        $limit = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wggithub_admin_requests.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('requests.php'));
        $adminObject->addItemButton(\_AM_WGGITHUB_ADD_REQUEST, 'requests.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $requestsCount = $requestsHandler->getCountRequests();
        $requestsAll = $requestsHandler->getAllRequests($start, $limit);
        $GLOBALS['xoopsTpl']->assign('requests_count', $requestsCount);
        $GLOBALS['xoopsTpl']->assign('wggithub_url', WGGITHUB_URL);
        $GLOBALS['xoopsTpl']->assign('wggithub_upload_url', WGGITHUB_UPLOAD_URL);
        // Table view requests
        if ($requestsCount > 0) {
            foreach (\array_keys($requestsAll) as $i) {
                $request = $requestsAll[$i]->getValuesRequests();
                $GLOBALS['xoopsTpl']->append('requests_list', $request);
                unset($request);
            }
            // Display Navigation
            if ($requestsCount > $limit) {
                include_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($requestsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_AM_WGGITHUB_THEREARENT_REQUESTS);
        }
        break;
    case 'new':
        $templateMain = 'wggithub_admin_requests.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('requests.php'));
        $adminObject->addItemButton(\_AM_WGGITHUB_REQUESTS_LIST, 'requests.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $requestsObj = $requestsHandler->create();
        $form = $requestsObj->getFormRequests();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('requests.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($reqId > 0) {
            $requestsObj = $requestsHandler->get($reqId);
        } else {
            $requestsObj = $requestsHandler->create();
        }
        // Set Vars
        $requestsObj->setVar('req_request', Request::getString('req_request', ''));
        $requestsObj->setVar('req_result', Request::getString('req_result', ''));
        $requestDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('req_datecreated'));
        $requestsObj->setVar('req_datecreated', $requestDatecreatedObj->getTimestamp());
        $requestsObj->setVar('req_submitter', Request::getInt('req_submitter', 0));
        // Insert Data
        if ($requestsHandler->insert($requestsObj)) {
            \redirect_header('requests.php?op=list', 2, \_AM_WGGITHUB_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $requestsObj->getHtmlErrors());
        $form = $requestsObj->getFormRequests();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wggithub_admin_requests.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('requests.php'));
        $adminObject->addItemButton(\_AM_WGGITHUB_ADD_REQUEST, 'requests.php?op=new', 'add');
        $adminObject->addItemButton(\_AM_WGGITHUB_REQUESTS_LIST, 'requests.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $requestsObj = $requestsHandler->get($reqId);
        $form = $requestsObj->getFormRequests();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wggithub_admin_requests.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('requests.php'));
        $requestsObj = $requestsHandler->get($reqId);
        $reqRequest = $requestsObj->getVar('req_request');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('requests.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($requestsHandler->delete($requestsObj)) {
                \redirect_header('requests.php', 3, \_AM_WGGITHUB_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $requestsObj->getHtmlErrors());
            }
        } else {
            $xoopsconfirm = new Common\XoopsConfirm(
                ['ok' => 1, 'req_id' => $reqId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_AM_WGGITHUB_FORM_SURE_DELETE, $requestsObj->getVar('req_request')));
            $form = $xoopsconfirm->getFormXoopsConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
