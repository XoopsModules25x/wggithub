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

use XoopsModules\Wggithub\Github\Http;
use XoopsModules\Wggithub\Github\Http\BadResponseException;


require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op    = Request::getCmd('op', 'list');
$setId = Request::getInt('set_id');
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('adminpager'));
$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);

switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $start = Request::getInt('start', 0);
        $limit = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wggithub_admin_settings.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('settings.php'));
        $adminObject->addItemButton(_AM_WGGITHUB_ADD_SETTING, 'settings.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $settingsCount = $settingsHandler->getCountSettings();
        $settingsAll = $settingsHandler->getAllSettings($start, $limit);
        $GLOBALS['xoopsTpl']->assign('settings_count', $settingsCount);
        $GLOBALS['xoopsTpl']->assign('wggithub_url', WGGITHUB_URL);
        $GLOBALS['xoopsTpl']->assign('wggithub_upload_url', WGGITHUB_UPLOAD_URL);
        // Table view settings
        if ($settingsCount > 0) {
            foreach (\array_keys($settingsAll) as $i) {
                $setting = $settingsAll[$i]->getValuesSettings();
                $GLOBALS['xoopsTpl']->append('settings_list', $setting);
                unset($setting);
            }
            // Display Navigation
            if ($settingsCount > $limit) {
                include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($settingsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', _AM_WGGITHUB_THEREARENT_SETTINGS);
        }
        break;
    case 'new':
        $templateMain = 'wggithub_admin_settings.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('settings.php'));
        $adminObject->addItemButton(_AM_WGGITHUB_SETTINGS_LIST, 'settings.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $settingsObj = $settingsHandler->create();
        $form = $settingsObj->getFormSettings(false, $start, $limit);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('settings.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($setId > 0) {
            $settingsObj = $settingsHandler->get($setId);
        } else {
            $settingsObj = $settingsHandler->create();
        }
        // Set Vars
        $settingsObj->setVar('set_username', Request::getString('set_username', ''));
        $settingsObj->setVar('set_token', Request::getString('set_token', ''));
        $settingsObj->setVar('set_options', Request::getString('set_options', ''));
        $settingsObj->setVar('set_primary', Request::getInt('set_primary', 0));
        $settingDateObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('set_date'));
        $settingsObj->setVar('set_date', $settingDateObj->getTimestamp());
        $settingsObj->setVar('set_submitter', Request::getInt('set_submitter', 0));
        // Insert Data
        if ($settingsHandler->insert($settingsObj)) {
            if (Request::getInt('set_primary', 0) > 0) {
                $newSetId = $settingsObj->getNewInsertedIdSettings();
                $setId = $setId > 0 ? $setId : $newSetId;
                $settingsHandler->setPrimarySetting($setId);
            }
            \redirect_header('settings.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 2, _AM_WGGITHUB_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $settingsObj->getHtmlErrors());
        $form = $settingsObj->getFormSettings(false, $start, $limit);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wggithub_admin_settings.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('settings.php'));
        $adminObject->addItemButton(_AM_WGGITHUB_ADD_SETTING, 'settings.php?op=new', 'add');
        $adminObject->addItemButton(_AM_WGGITHUB_SETTINGS_LIST, 'settings.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $settingsObj = $settingsHandler->get($setId);
        $form = $settingsObj->getFormSettings(false, $start, $limit);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wggithub_admin_settings.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('settings.php'));
        $settingsObj = $settingsHandler->get($setId);
        $setToken = $settingsObj->getVar('set_token');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('settings.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($settingsHandler->delete($settingsObj)) {
                \redirect_header('settings.php', 3, _AM_WGGITHUB_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $settingsObj->getHtmlErrors());
            }
        } else {
            $xoopsconfirm = new Common\XoopsConfirm(
                ['ok' => 1, 'set_id' => $setId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(_AM_WGGITHUB_FORM_SURE_DELETE, $settingsObj->getVar('set_token')));
            $form = $xoopsconfirm->getFormXoopsConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
    case 'test':
        $templateMain = 'wggithub_admin_settings.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('settings.php'));
        $adminObject->addItemButton(_AM_WGGITHUB_ADD_SETTING, 'settings.php?op=new', 'add');
        $adminObject->addItemButton(_AM_WGGITHUB_SETTINGS_LIST, 'settings.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));

        $client = Wggithub\Github\GithubClient::getInstance();
        $result = $client->testApi1('emojis');
        if ($result) {
            $info = 'Github/GithubClient testApi1 (reading github public repos) successfully finished';
        } else {
            $info = 'Github/GithubClient testApi1 (reading github public repos) failed';
        }
        $GLOBALS['xoopsTpl']->assign('info1', $info);
        break;
}
require __DIR__ . '/footer.php';
