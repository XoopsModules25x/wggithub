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


/**
 * search callback functions
 *
 * @param $queryarray
 * @param $andor
 * @param $limit
 * @param $offset
 * @param $userid
 * @return mixed $itemIds
 */
function wggithub_search($queryarray, $andor, $limit, $offset, $userid)
{
    $ret = [];
    $helper = \XoopsModules\Wggithub\Helper::getInstance();

    // search in table repositories
    // search keywords
    $elementCount = 0;
    $repositoriesHandler = $helper->getHandler('Repositories');
    if (\is_array($queryarray)) {
        $elementCount = \count($queryarray);
    }
    if ($elementCount > 0) {
        $crKeywords = new \CriteriaCompo();
        for ($i = 0; $i  <  $elementCount; $i++) {
            $crKeyword = new \CriteriaCompo();
            unset($crKeyword);
        }
    }
    // search user(s)
    if ($userid && \is_array($userid)) {
        $userid = array_map('intval', $userid);
        $crUser = new \CriteriaCompo();
        $crUser->add(new \Criteria('repo_submitter', '(' . \implode(',', $userid) . ')', 'IN'), 'OR');
    } elseif (is_numeric($userid) && $userid > 0) {
        $crUser = new \CriteriaCompo();
        $crUser->add(new \Criteria('repo_submitter', $userid), 'OR');
    }
    $crSearch = new \CriteriaCompo();
    if (isset($crKeywords)) {
        $crSearch->add($crKeywords, 'AND');
    }
    if (isset($crUser)) {
        $crSearch->add($crUser, 'AND');
    }
    $crSearch->setStart($offset);
    $crSearch->setLimit($limit);
    $crSearch->setSort('repo_datecreated');
    $crSearch->setOrder('DESC');
    $repositoriesAll = $repositoriesHandler->getAll($crSearch);
    foreach (\array_keys($repositoriesAll) as $i) {
        $ret[] = [
            'image'  => 'assets/icons/16/repositories.png',
            'link'   => 'repositories.php?op=show&amp;repo_id=' . $repositoriesAll[$i]->getVar('repo_id'),
            'title'  => $repositoriesAll[$i]->getVar('repo_name'),
            'time'   => $repositoriesAll[$i]->getVar('repo_datecreated')
        ];
    }
    unset($crKeywords);
    unset($crKeyword);
    unset($crUser);
    unset($crSearch);




    return $ret;

}
