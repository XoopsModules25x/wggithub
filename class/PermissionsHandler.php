<?php

namespace XoopsModules\Wggithub;

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
use XoopsModules\Wggithub\Constants;

\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object PermissionsHandler
 */
class PermissionsHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
    }

    /**
     * @public function getPermGlobalRead
     * returns global right for reading from github
     *
     * @param null
     * @return bool
     */
    public function getPermGlobalRead()
    {
        global $xoopsUser, $xoopsModule;
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);
        }
        if ($grouppermHandler->checkRight('wggithub_ac', Constants::PERM_GLOBAL_READ, $my_group_ids, $mid)) {
            return true;
        }
        return false;
    }

    /**
     * @public function permGlobalSubmit
     * returns right for global view
     *
     * @param null
     * @return bool
     */
    public function getPermGlobalView()
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalRead()) {
            return true;
        }

        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);
        }
        if ($grouppermHandler->checkRight('wggithub_ac', Constants::PERM_GLOBAL_VIEW, $my_group_ids, $mid)) {
            return true;
        }
        return false;
    }

    /**
     * @public function getPermReadmeUpdate
     * returns right for updating existing readme
     *
     * @param null
     * @return bool
     */
    public function getPermReadmeUpdate()
    {
        global $xoopsUser, $xoopsModule;
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);
        }
        if ($grouppermHandler->checkRight('wggithub_ac', Constants::PERM_README_UPDATE, $my_group_ids, $mid)) {
            return true;
        }
        return false;
    }
}
