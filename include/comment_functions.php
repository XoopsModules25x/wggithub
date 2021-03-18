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

/**
 * CommentsUpdate
 *
 * @param mixed  $itemId
 * @param mixed  $itemNumb
 * @return bool
 */
function wggithubCommentsUpdate($itemId, $itemNumb)
{
	// Get instance of module
	$helper = \XoopsModules\Wggithub\Helper::getInstance();
	$repositoriesHandler = $helper->getHandler('Repositories');
	$repoId = (int)$itemId;
	$repositoriesObj = $repositoriesHandler->get($repoId);
	$repositoriesObj->setVar('repo_comments', (int)$itemNumb);
	if ($repositoriesHandler->insert($repositoriesObj)) {
		return true;
	}
	return false;
}

/**
 * CommentsApprove
 *
 * @param mixed $comment
 * @return bool
 */
function wggithubCommentsApprove($comment)
{
	// Notification event
	// Get instance of module
	$helper = \XoopsModules\Wggithub\Helper::getInstance();
	$repositoriesHandler = $helper->getHandler('Repositories');
	$repoId = $comment->getVar('com_itemid');
	$repositoriesObj = $repositoriesHandler->get($repoId);
	$repoName = $repositoriesObj->getVar('repo_name');

	$tags = [];
	$tags['ITEM_NAME'] = $repoName;
	$tags['ITEM_URL']  = \XOOPS_URL . '/modules/wggithub/repositories.php?op=show&repo_id=' . $repoId;
	$notificationHandler = \xoops_getHandler('notification');
	// Event modify notification
	$notificationHandler->triggerEvent('global', 0, 'global_comment', $tags);
	$notificationHandler->triggerEvent('repositories', $repoId, 'repository_comment', $tags);
	return true;

}
