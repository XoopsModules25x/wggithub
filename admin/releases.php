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
$relId = Request::getInt('rel_id');
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('adminpager'));
$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);

switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $templateMain = 'wggithub_admin_releases.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('releases.php'));

        $filterValue = '';
        $crReleases = new \CriteriaCompo();
        if ('filter' == $op) {
            $operand = Request::getInt('filter_operand', 0);
            $filterField = Request::getString('filter_field', '');
            $filterValue = Request::getString('filter_value', 'none');
            if (Constants::FILTER_OPERAND_EQUAL == $operand) {
                $crReleases->add(new \Criteria($filterField, $filterValue));
            } elseif (Constants::FILTER_OPERAND_LIKE == $operand) {
                $crReleases->add(new \Criteria($filterField, "%$filterValue%", 'LIKE'));
            }
        }
        $crReleases->setStart($start);
        $crReleases->setLimit($limit);
        $releasesCount = $releasesHandler->getCount($crReleases);
        $releasesAll = $releasesHandler->getAll($crReleases);
        $GLOBALS['xoopsTpl']->assign('releases_count', $releasesCount);
        $GLOBALS['xoopsTpl']->assign('wggithub_url', \WGGITHUB_URL);
        $GLOBALS['xoopsTpl']->assign('wggithub_upload_url', \WGGITHUB_UPLOAD_URL);
        // Table view releases
        if ($releasesCount > 0) {
            foreach (\array_keys($releasesAll) as $i) {
                $release = $releasesAll[$i]->getValuesReleases();
                $GLOBALS['xoopsTpl']->append('releases_list', $release);
                unset($release);
            }
            // Display Navigation
            if ($releasesCount > $limit) {
                include_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($releasesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            if ('filter' == $op) {
                $GLOBALS['xoopsTpl']->assign('noData', \_AM_WGGITHUB_THEREARENT_RELEASES_FILTER);
            } else {
                $GLOBALS['xoopsTpl']->assign('noData', \_AM_WGGITHUB_THEREARENT_RELEASES);
            }
        }
        $form = $releasesHandler->getFormFilterReleases(false, $start, $limit, $filterValue);
        $GLOBALS['xoopsTpl']->assign('formFilter', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('releases.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($relId > 0) {
            $releasesObj = $releasesHandler->get($relId);
        } else {
            $releasesObj = $releasesHandler->create();
        }
        // Set Vars
        $releasesObj->setVar('rel_repoid', Request::getInt('rel_repoid', 0));
        $releasesObj->setVar('rel_type', Request::getInt('rel_type', 0));
        $releasesObj->setVar('rel_name', Request::getString('rel_name', ''));
        $releasePublishedatObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('rel_publishedat'));
        $releasesObj->setVar('rel_publishedat', $releasePublishedatObj->getTimestamp());
        $releasesObj->setVar('rel_tarballurl', Request::getString('rel_tarballurl', ''));
        $releasesObj->setVar('rel_zipballurl', Request::getString('rel_zipballurl', ''));
        $releaseDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('rel_datecreated'));
        $releasesObj->setVar('rel_datecreated', $releaseDatecreatedObj->getTimestamp());
        $releasesObj->setVar('rel_submitter', Request::getInt('rel_submitter', 0));
        // Insert Data
        if ($releasesHandler->insert($releasesObj)) {
            \redirect_header('releases.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 2, \_AM_WGGITHUB_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $releasesObj->getHtmlErrors());
        $form = $releasesObj->getFormReleases(false, $start, $limit);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wggithub_admin_releases.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('releases.php'));
        $adminObject->addItemButton(\_AM_WGGITHUB_RELEASES_LIST, 'releases.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $releasesObj = $releasesHandler->get($relId);
        $form = $releasesObj->getFormReleases(false, $start, $limit);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wggithub_admin_releases.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('releases.php'));
        $releasesObj = $releasesHandler->get($relId);
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('releases.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($releasesHandler->delete($releasesObj)) {
                \redirect_header('releases.php', 3, \_AM_WGGITHUB_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $releasesObj->getHtmlErrors());
            }
        } else {
            $repositoriesObj = $repositoriesHandler->get($releasesObj->getVar('rel_repoid'));
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'rel_id' => $relId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_AM_WGGITHUB_FORM_SURE_DELETE, $repositoriesObj->getVar('repo_name') . ' - ' . $releasesObj->getVar('rel_name')));
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
