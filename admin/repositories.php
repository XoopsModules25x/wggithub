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
$op     = Request::getCmd('op', 'list');
$repoId = Request::getInt('repo_id');
$start  = Request::getInt('start', 0);
$limit  = Request::getInt('limit', $helper->getConfig('adminpager'));
$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);


switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $templateMain = 'wggithub_admin_repositories.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('repositories.php'));
        $adminObject->addItemButton(\_AM_WGGITHUB_ADD_REPOSITORY, 'repositories.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));

        $autoApproved = (int)$helper->getConfig('autoapproved');
        $GLOBALS['xoopsTpl']->assign('autoApproved', !$autoApproved);
        $GLOBALS['xoopsTpl']->assign('wggithub_icons_url_16', WGGITHUB_ICONS_URL . '/16');

        $filterValue = '';
        $filterStatus = 0;
        $crRepositories = new \CriteriaCompo();
        if ('filter' == $op) {
            $operand = Request::getInt('filter_operand', 0);
            $filterField = Request::getString('filter_field', '');
            $filterValue = Request::getString('filter_value', '');
            if ('' !== $filterValue) {
                if (Constants::FILTER_OPERAND_EQUAL == $operand) {
                    $crRepositories->add(new Criteria($filterField, $filterValue));
                } elseif (Constants::FILTER_OPERAND_LIKE == $operand) {
                    $crRepositories->add(new Criteria($filterField, "%$filterValue%", 'LIKE'));
                }
            }
            $filterStatus = Request::getInt('filter_status');
            if ($filterStatus > 0) {
                $crRepositories->add(new Criteria('repo_status', $filterStatus));
            }
        }
        $crRepositories->setStart($start);
        $crRepositories->setLimit($limit);
        $repositoriesCount = $repositoriesHandler->getCount($crRepositories);
        $repositoriesAll = $repositoriesHandler->getAll($crRepositories);
        $GLOBALS['xoopsTpl']->assign('repositories_count', $repositoriesCount);
        $GLOBALS['xoopsTpl']->assign('wggithub_url', WGGITHUB_URL);
        $GLOBALS['xoopsTpl']->assign('wggithub_upload_url', WGGITHUB_UPLOAD_URL);
        // Table view repositories
        if ($repositoriesCount > 0) {
            foreach (\array_keys($repositoriesAll) as $i) {
                $repository = $repositoriesAll[$i]->getValuesRepositories();
                $GLOBALS['xoopsTpl']->append('repositories_list', $repository);
                unset($repository);
            }
            // Display Navigation
            if ($repositoriesCount > $limit) {
                include_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($repositoriesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            if ('filter' == $op) {
                $GLOBALS['xoopsTpl']->assign('noData', \_AM_WGGITHUB_THEREARENT_REPOSITORIES_FILTER);
            } else {
                $GLOBALS['xoopsTpl']->assign('noData', \_AM_WGGITHUB_THEREARENT_REPOSITORIES);
            }
        }
        $form = $repositoriesHandler->getFormFilterRepos(false, $start, $limit, $filterValue, $filterStatus);
        $GLOBALS['xoopsTpl']->assign('formFilter', $form->render());
        break;
    case 'new':
        $templateMain = 'wggithub_admin_repositories.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('repositories.php'));
        $adminObject->addItemButton(\_AM_WGGITHUB_REPOSITORIES_LIST, 'repositories.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $repositoriesObj = $repositoriesHandler->create();
        $form = $repositoriesObj->getFormRepositories(false, $start, $limit);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('repositories.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($repoId > 0) {
            $repositoriesObj = $repositoriesHandler->get($repoId);
        } else {
            $repositoriesObj = $repositoriesHandler->create();
        }
        // Set Vars
        $repositoriesObj->setVar('repo_nodeid', Request::getString('repo_nodeid', ''));
        $repositoriesObj->setVar('repo_user', Request::getString('repo_user', ''));
        $repositoriesObj->setVar('repo_name', Request::getString('repo_name', ''));
        $repositoriesObj->setVar('repo_fullname', Request::getString('repo_fullname', ''));
        $repositoryCreatedatObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('repo_createdat'));
        $repositoriesObj->setVar('repo_createdat', $repositoryCreatedatObj->getTimestamp());
        $repositoryUpdatedatObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('repo_updatedat'));
        $repositoriesObj->setVar('repo_updatedat', $repositoryUpdatedatObj->getTimestamp());
        $repositoriesObj->setVar('repo_htmlurl', Request::getString('repo_htmlurl', ''));
        $repositoriesObj->setVar('repo_prerelease', Request::getInt('repo_prerelease', 0));
        $repositoriesObj->setVar('repo_release', Request::getInt('repo_release', 0));
        $repositoriesObj->setVar('repo_status', Request::getInt('repo_status', 0));
        $repositoryDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('repo_datecreated'));
        $repositoriesObj->setVar('repo_datecreated', $repositoryDatecreatedObj->getTimestamp());
        $repositoriesObj->setVar('repo_submitter', Request::getInt('repo_submitter', 0));
        // Insert Data
        if ($repositoriesHandler->insert($repositoriesObj)) {
            \redirect_header('repositories.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 2, \_AM_WGGITHUB_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $repositoriesObj->getHtmlErrors());
        $form = $repositoriesObj->getFormRepositories(false, $start, $limit);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wggithub_admin_repositories.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('repositories.php'));
        $adminObject->addItemButton(\_AM_WGGITHUB_ADD_REPOSITORY, 'repositories.php?op=new', 'add');
        $adminObject->addItemButton(\_AM_WGGITHUB_REPOSITORIES_LIST, 'repositories.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $repositoriesObj = $repositoriesHandler->get($repoId);
        $form = $repositoriesObj->getFormRepositories(false, $start, $limit);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wggithub_admin_repositories.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('repositories.php'));
        $repositoriesObj = $repositoriesHandler->get($repoId);
        $repoName = $repositoriesObj->getVar('repo_name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('repositories.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($repositoriesHandler->delete($repositoriesObj)) {
                \redirect_header('repositories.php', 3, \_AM_WGGITHUB_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $repositoriesObj->getHtmlErrors());
            }
        } else {
            $xoopsconfirm = new Common\XoopsConfirm(
                ['ok' => 1, 'repo_id' => $repoId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_AM_WGGITHUB_FORM_SURE_DELETE, $repositoriesObj->getVar('repo_name')));
            $form = $xoopsconfirm->getFormXoopsConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
    case 'change_yn':
        if ($repoId > 0) {
            $repositoriesObj = $repositoriesHandler->get($repoId);
            $repositoriesObj->setVar(Request::getString('field'), Request::getInt('value', 0));
            // Insert Data
            if ($repositoriesHandler->insert($repositoriesObj, true)) {
                \redirect_header('repositories.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 2, \_AM_WGGITHUB_FORM_OK);
            }
        }
        break;
}
require __DIR__ . '/footer.php';
