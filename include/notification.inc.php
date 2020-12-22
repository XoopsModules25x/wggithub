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

/**
 * comment callback functions
 *
 * @param  $category
 * @param  $item_id
 * @return array item|null
 */
function wggithub_notify_iteminfo($category, $item_id)
{
    global $xoopsDB;

    if (!\defined('WGGITHUB_URL')) {
        \define('WGGITHUB_URL', \XOOPS_URL . '/modules/wggithub');
    }

    switch ($category) {
        case 'global':
            $item['name'] = '';
            $item['url']  = '';
            return $item;
            break;
        case 'repositories':
            $sql          = 'SELECT repo_name FROM ' . $xoopsDB->prefix('wggithub_repositories') . ' WHERE repo_id = '. $item_id;
            $result       = $xoopsDB->query($sql);
            $result_array = $xoopsDB->fetchArray($result);
            $item['name'] = $result_array['repo_name'];
            $item['url']  = WGGITHUB_URL . '/repositories.php?repo_id=' . $item_id;
            return $item;
            break;
    }
    return null;
}
