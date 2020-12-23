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

include_once 'common.php';

// ---------------- Admin Main ----------------
\define('_MI_WGGITHUB_NAME', 'wgGitHub');
\define('_MI_WGGITHUB_DESC', 'This module is for doing following...');
// ---------------- Admin Menu ----------------
\define('_MI_WGGITHUB_ADMENU1', 'Dashboard');
\define('_MI_WGGITHUB_ADMENU2', 'Settings');
\define('_MI_WGGITHUB_ADMENU3', 'Directories');
\define('_MI_WGGITHUB_ADMENU4', 'Logs');
\define('_MI_WGGITHUB_ADMENU5', 'Repositories');
\define('_MI_WGGITHUB_ADMENU6', 'Readmes');
\define('_MI_WGGITHUB_ADMENU7', 'Releases');
\define('_MI_WGGITHUB_ADMENU8', 'Permissions');
\define('_MI_WGGITHUB_ADMENU9', 'Feedback');
\define('_MI_WGGITHUB_ABOUT', 'About');
// ---------------- Admin Nav ----------------
\define('_MI_WGGITHUB_ADMIN_PAGER', 'Admin pager');
\define('_MI_WGGITHUB_ADMIN_PAGER_DESC', 'Admin per page list');
// User
\define('_MI_WGGITHUB_USER_PAGER', 'User pager');
\define('_MI_WGGITHUB_USER_PAGER_DESC', 'User per page list');
// Blocks
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK', 'Repositories block');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_DESC', 'Repositories block description');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_REPOSITORY', 'Repositories block  REPOSITORY');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_REPOSITORY_DESC', 'Repositories block  REPOSITORY description');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_LAST', 'Repositories block last');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_LAST_DESC', 'Repositories block last description');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_NEW', 'Repositories block new');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_NEW_DESC', 'Repositories block new description');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_HITS', 'Repositories block hits');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_HITS_DESC', 'Repositories block hits description');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_TOP', 'Repositories block top');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_TOP_DESC', 'Repositories block top description');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_RANDOM', 'Repositories block random');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_RANDOM_DESC', 'Repositories block random description');
// Config
\define('_MI_WGGITHUB_EDITOR_ADMIN', 'Editor admin');
\define('_MI_WGGITHUB_EDITOR_ADMIN_DESC', 'Select the editor which should be used in admin area for text area fields');
\define('_MI_WGGITHUB_EDITOR_USER', 'Editor user');
\define('_MI_WGGITHUB_EDITOR_USER_DESC', 'Select the editor which should be used in user area for text area fields');
\define('_MI_WGGITHUB_EDITOR_MAXCHAR', 'Text max characters');
\define('_MI_WGGITHUB_EDITOR_MAXCHAR_DESC', 'Max characters for showing text of a textarea or editor field in admin area');
\define('_MI_WGGITHUB_KEYWORDS', 'Keywords');
\define('_MI_WGGITHUB_KEYWORDS_DESC', 'Insert here the keywords (separate by comma)');
\define('_MI_WGGITHUB_NUMB_COL', 'Number Columns');
\define('_MI_WGGITHUB_NUMB_COL_DESC', 'Number Columns to View.');
\define('_MI_WGGITHUB_DIVIDEBY', 'Divide By');
\define('_MI_WGGITHUB_DIVIDEBY_DESC', 'Divide by columns number.');
\define('_MI_WGGITHUB_TABLE_TYPE', 'Table Type');
\define('_MI_WGGITHUB_TABLE_TYPE_DESC', 'Table Type is the bootstrap html table.');
\define('_MI_WGGITHUB_PANEL_TYPE', 'Panel Type');
\define('_MI_WGGITHUB_PANEL_TYPE_DESC', 'Panel Type is the bootstrap html div.');
\define('_MI_WGGITHUB_IDPAYPAL', 'Paypal ID');
\define('_MI_WGGITHUB_IDPAYPAL_DESC', 'Insert here your PayPal ID for donactions.');
\define('_MI_WGGITHUB_ADVERTISE', 'Advertisement Code');
\define('_MI_WGGITHUB_ADVERTISE_DESC', 'Insert here the advertisement code');
\define('_MI_WGGITHUB_MAINTAINEDBY', 'Maintained By');
\define('_MI_WGGITHUB_MAINTAINEDBY_DESC', 'Allow url of support site or community');
\define('_MI_WGGITHUB_BOOKMARKS', 'Social Bookmarks');
\define('_MI_WGGITHUB_BOOKMARKS_DESC', 'Show Social Bookmarks in the single page');
\define('_MI_WGGITHUB_FACEBOOK_COMMENTS', 'Facebook comments');
\define('_MI_WGGITHUB_FACEBOOK_COMMENTS_DESC', 'Allow Facebook comments in the single page');
\define('_MI_WGGITHUB_DISQUS_COMMENTS', 'Disqus comments');
\define('_MI_WGGITHUB_DISQUS_COMMENTS_DESC', 'Allow Disqus comments in the single page');
// ---------------- End ----------------
