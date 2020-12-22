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

use XoopsModules\Wggithub;
use XoopsModules\Wggithub\Helper;
use XoopsModules\Wggithub\Constants;

include_once XOOPS_ROOT_PATH . '/modules/wggithub/include/common.php';

/**
 * Function show block
 * @param  $options
 * @return array
 */
function b_wggithub_repositories_show($options)
{
    include_once XOOPS_ROOT_PATH . '/modules/wggithub/class/repositories.php';
    $myts = MyTextSanitizer::getInstance();
    $GLOBALS['xoopsTpl']->assign('wggithub_upload_url', WGGITHUB_UPLOAD_URL);
    $block       = [];
    $typeBlock   = $options[0];
    $limit       = $options[1];
    $lenghtTitle = $options[2];
    $helper      = Helper::getInstance();
    $repositoriesHandler = $helper->getHandler('Repositories');
    $crRepositories = new \CriteriaCompo();
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);

    switch ($typeBlock) {
        case 'last':
        default:
            // For the block: repositories last
            $crRepositories->setSort('repo_datecreated');
            $crRepositories->setOrder('DESC');
            break;
        case 'new':
            // For the block: repositories new
            $crRepositories->add(new \Criteria('repo_datecreated', \DateTime::createFromFormat(_SHORTDATESTRING), '>='));
            $crRepositories->add(new \Criteria('repo_datecreated', \DateTime::createFromFormat(_SHORTDATESTRING) + 86400, '<='));
            $crRepositories->setSort('repo_datecreated');
            $crRepositories->setOrder('ASC');
            break;
        case 'hits':
            // For the block: repositories hits
            $crRepositories->setSort('repo_hits');
            $crRepositories->setOrder('DESC');
            break;
        case 'top':
            // For the block: repositories top
            $crRepositories->setSort('repo_top');
            $crRepositories->setOrder('ASC');
            break;
        case 'random':
            // For the block: repositories random
            $crRepositories->setSort('RAND()');
            break;
    }

    $crRepositories->setLimit($limit);
    $repositoriesAll = $repositoriesHandler->getAll($crRepositories);
    unset($crRepositories);
    if (\count($repositoriesAll) > 0) {
        foreach (\array_keys($repositoriesAll) as $i) {
            $block[$i]['name'] = $myts->htmlSpecialChars($repositoriesAll[$i]->getVar('repo_name'));
            $block[$i]['htmlurl'] = $myts->htmlSpecialChars($repositoriesAll[$i]->getVar('repo_htmlurl'));
        }
    }

    return $block;

}

/**
 * Function edit block
 * @param  $options
 * @return string
 */
function b_wggithub_repositories_edit($options)
{
    include_once XOOPS_ROOT_PATH . '/modules/wggithub/class/repositories.php';
    $helper = Helper::getInstance();
    $repositoriesHandler = $helper->getHandler('Repositories');
    $GLOBALS['xoopsTpl']->assign('wggithub_upload_url', WGGITHUB_UPLOAD_URL);
    $form = _MB_WGGITHUB_DISPLAY;
    $form .= "<input type='hidden' name='options[0]' value='".$options[0]."' />";
    $form .= "<input type='text' name='options[1]' size='5' maxlength='255' value='" . $options[1] . "' />&nbsp;<br>";
    $form .= _MB_WGGITHUB_TITLE_LENGTH . " : <input type='text' name='options[2]' size='5' maxlength='255' value='" . $options[2] . "' /><br><br>";
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);

    $crRepositories = new \CriteriaCompo();
    $crRepositories->add(new \Criteria('repo_id', 0, '!='));
    $crRepositories->setSort('repo_id');
    $crRepositories->setOrder('ASC');
    $repositoriesAll = $repositoriesHandler->getAll($crRepositories);
    unset($crRepositories);
    $form .= _MB_WGGITHUB_REPOSITORIES_TO_DISPLAY . "<br><select name='options[]' multiple='multiple' size='5'>";
    $form .= "<option value='0' " . (\in_array(0, $options) == false ? '' : "selected='selected'") . '>' . _MB_WGGITHUB_ALL_REPOSITORIES . '</option>';
    foreach (\array_keys($repositoriesAll) as $i) {
        $repo_id = $repositoriesAll[$i]->getVar('repo_id');
        $form .= "<option value='" . $repo_id . "' " . (\in_array($repo_id, $options) == false ? '' : "selected='selected'") . '>' . $repositoriesAll[$i]->getVar('repo_name') . '</option>';
    }
    $form .= '</select>';

    return $form;

}
