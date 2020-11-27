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

// 
$moduleDirName      = \basename(__DIR__);
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);
// ------------------- Informations ------------------- //
$modversion = [
	'name'                => _MI_WGGITHUB_NAME,
	'version'             => 1.01,
	'description'         => _MI_WGGITHUB_DESC,
	'author'              => 'Goffy - XOOPS Development Team',
	'author_mail'         => 'goffy@wedega.com',
	'author_website_url'  => 'https://wedega.com',
	'author_website_name' => 'XOOPS on Wedega',
	'credits'             => 'Goffy - XOOPS Development Team',
	'license'             => 'GPL 2.0 or later',
	'license_url'         => 'http://www.gnu.org/licenses/gpl-3.0.en.html',
	'help'                => 'page=help',
	'release_info'        => 'release_info',
	'release_file'        => XOOPS_URL . '/modules/wggithub/docs/release_info file',
	'release_date'        => '2020/11/21',
	'manual'              => 'link to manual file',
	'manual_file'         => XOOPS_URL . '/modules/wggithub/docs/install.txt',
	'min_php'             => '7.2',
	'min_xoops'           => '2.5.10',
	'min_admin'           => '1.2',
	'min_db'              => ['mysql' => '5.6', 'mysqli' => '5.6'],
	'image'               => 'assets/images/logoModule.png',
	'dirname'             => \basename(__DIR__),
	'dirmoduleadmin'      => 'Frameworks/moduleclasses/moduleadmin',
	'sysicons16'          => '../../Frameworks/moduleclasses/icons/16',
	'sysicons32'          => '../../Frameworks/moduleclasses/icons/32',
	'modicons16'          => 'assets/icons/16',
	'modicons32'          => 'assets/icons/32',
	'demo_site_url'       => 'https://xoops.org',
	'demo_site_name'      => 'XOOPS Demo Site',
	'support_url'         => 'https://xoops.org/modules/newbb',
	'support_name'        => 'Support Forum',
	'module_website_url'  => 'www.xoops.org',
	'module_website_name' => 'XOOPS Project',
	'release'             => '2017-12-02',
	'module_status'       => 'Beta 1',
	'system_menu'         => 1,
	'hasAdmin'            => 1,
	'hasMain'             => 1,
	'adminindex'          => 'admin/index.php',
	'adminmenu'           => 'admin/menu.php',
	'onInstall'           => 'include/install.php',
	'onUninstall'         => 'include/uninstall.php',
	'onUpdate'            => 'include/update.php',
];
// ------------------- Templates ------------------- //
$modversion['templates'] = [
	// Admin templates
	['file' => 'wggithub_admin_about.tpl', 'description' => '', 'type' => 'admin'],
	['file' => 'wggithub_admin_header.tpl', 'description' => '', 'type' => 'admin'],
	['file' => 'wggithub_admin_index.tpl', 'description' => '', 'type' => 'admin'],
	['file' => 'wggithub_admin_settings.tpl', 'description' => '', 'type' => 'admin'],
	['file' => 'wggithub_admin_repositories.tpl', 'description' => '', 'type' => 'admin'],
	['file' => 'wggithub_admin_directories.tpl', 'description' => '', 'type' => 'admin'],
	['file' => 'wggithub_admin_requests.tpl', 'description' => '', 'type' => 'admin'],
	['file' => 'wggithub_admin_readmes.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wggithub_admin_releases.tpl', 'description' => '', 'type' => 'admin'],
	['file' => 'wggithub_admin_permissions.tpl', 'description' => '', 'type' => 'admin'],
	['file' => 'wggithub_admin_footer.tpl', 'description' => '', 'type' => 'admin'],
	// User templates
	['file' => 'wggithub_header.tpl', 'description' => ''],
	['file' => 'wggithub_index.tpl', 'description' => ''],
	['file' => 'wggithub_repositories.tpl', 'description' => ''],
	['file' => 'wggithub_repositories_list.tpl', 'description' => ''],
	['file' => 'wggithub_repositories_item.tpl', 'description' => ''],
	['file' => 'wggithub_directories.tpl', 'description' => ''],
	['file' => 'wggithub_directories_list.tpl', 'description' => ''],
	['file' => 'wggithub_directories_item.tpl', 'description' => ''],
	['file' => 'wggithub_readmes.tpl', 'description' => ''],
	['file' => 'wggithub_readmes_list.tpl', 'description' => ''],
	['file' => 'wggithub_readmes_item.tpl', 'description' => ''],
	['file' => 'wggithub_breadcrumbs.tpl', 'description' => ''],
	['file' => 'wggithub_search.tpl', 'description' => ''],
	['file' => 'wggithub_footer.tpl', 'description' => ''],
];
// ------------------- Mysql ------------------- //
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
// Tables
$modversion['tables'] = [
	'wggithub_settings',
	'wggithub_repositories',
	'wggithub_directories',
	'wggithub_requests',
	'wggithub_readmes',
    'wggithub_releases',
];
// ------------------- Search ------------------- //
$modversion['hasSearch'] = 1;
$modversion['search'] = [
	'file' => 'include/search.inc.php',
	'func' => 'wggithub_search',
];
// ------------------- Blocks ------------------- //
// Repositories last
$modversion['blocks'][] = [
	'file'        => 'repositories.php',
	'name'        => _MI_WGGITHUB_REPOSITORIES_BLOCK_LAST,
	'description' => _MI_WGGITHUB_REPOSITORIES_BLOCK_LAST_DESC,
	'show_func'   => 'b_wggithub_repositories_show',
	'edit_func'   => 'b_wggithub_repositories_edit',
	'template'    => 'wggithub_block_repositories.tpl',
	'options'     => 'last|5|25|0',
];
// Repositories new
$modversion['blocks'][] = [
	'file'        => 'repositories.php',
	'name'        => _MI_WGGITHUB_REPOSITORIES_BLOCK_NEW,
	'description' => _MI_WGGITHUB_REPOSITORIES_BLOCK_NEW_DESC,
	'show_func'   => 'b_wggithub_repositories_show',
	'edit_func'   => 'b_wggithub_repositories_edit',
	'template'    => 'wggithub_block_repositories.tpl',
	'options'     => 'new|5|25|0',
];
// Repositories hits
$modversion['blocks'][] = [
	'file'        => 'repositories.php',
	'name'        => _MI_WGGITHUB_REPOSITORIES_BLOCK_HITS,
	'description' => _MI_WGGITHUB_REPOSITORIES_BLOCK_HITS_DESC,
	'show_func'   => 'b_wggithub_repositories_show',
	'edit_func'   => 'b_wggithub_repositories_edit',
	'template'    => 'wggithub_block_repositories.tpl',
	'options'     => 'hits|5|25|0',
];
// Repositories top
$modversion['blocks'][] = [
	'file'        => 'repositories.php',
	'name'        => _MI_WGGITHUB_REPOSITORIES_BLOCK_TOP,
	'description' => _MI_WGGITHUB_REPOSITORIES_BLOCK_TOP_DESC,
	'show_func'   => 'b_wggithub_repositories_show',
	'edit_func'   => 'b_wggithub_repositories_edit',
	'template'    => 'wggithub_block_repositories.tpl',
	'options'     => 'top|5|25|0',
];
// Repositories random
$modversion['blocks'][] = [
	'file'        => 'repositories.php',
	'name'        => _MI_WGGITHUB_REPOSITORIES_BLOCK_RANDOM,
	'description' => _MI_WGGITHUB_REPOSITORIES_BLOCK_RANDOM_DESC,
	'show_func'   => 'b_wggithub_repositories_show',
	'edit_func'   => 'b_wggithub_repositories_edit',
	'template'    => 'wggithub_block_repositories.tpl',
	'options'     => 'random|5|25|0',
];
// ------------------- Config ------------------- //
// Editor Admin
\xoops_load('xoopseditorhandler');
$editorHandler = XoopsEditorHandler::getInstance();
$modversion['config'][] = [
	'name'        => 'editor_admin',
	'title'       => '_MI_WGGITHUB_EDITOR_ADMIN',
	'description' => '_MI_WGGITHUB_EDITOR_ADMIN_DESC',
	'formtype'    => 'select',
	'valuetype'   => 'text',
	'default'     => 'dhtml',
	'options'     => array_flip($editorHandler->getList()),
];
// Editor User
\xoops_load('xoopseditorhandler');
$editorHandler = XoopsEditorHandler::getInstance();
$modversion['config'][] = [
	'name'        => 'editor_user',
	'title'       => '_MI_WGGITHUB_EDITOR_USER',
	'description' => '_MI_WGGITHUB_EDITOR_USER_DESC',
	'formtype'    => 'select',
	'valuetype'   => 'text',
	'default'     => 'dhtml',
	'options'     => array_flip($editorHandler->getList()),
];
// Editor : max characters admin area
$modversion['config'][] = [
	'name'        => 'editor_maxchar',
	'title'       => '_MI_WGGITHUB_EDITOR_MAXCHAR',
	'description' => '_MI_WGGITHUB_EDITOR_MAXCHAR_DESC',
	'formtype'    => 'textbox',
	'valuetype'   => 'int',
	'default'     => 50,
];
// Get groups
$memberHandler = \xoops_getHandler('member');
$xoopsGroups  = $memberHandler->getGroupList();
$groups = [];
foreach ($xoopsGroups as $key => $group) {
	$groups[$group]  = $key;
}
// General access groups
$modversion['config'][] = [
	'name'        => 'groups',
	'title'       => '_MI_WGGITHUB_GROUPS',
	'description' => '_MI_WGGITHUB_GROUPS_DESC',
	'formtype'    => 'select_multi',
	'valuetype'   => 'array',
	'default'     => $groups,
	'options'     => $groups,
];
// Upload groups
$modversion['config'][] = [
	'name'        => 'upload_groups',
	'title'       => '_MI_WGGITHUB_UPLOAD_GROUPS',
	'description' => '_MI_WGGITHUB_UPLOAD_GROUPS_DESC',
	'formtype'    => 'select_multi',
	'valuetype'   => 'array',
	'default'     => $groups,
	'options'     => $groups,
];
// Get Admin groups
$crGroups = new \CriteriaCompo();
$crGroups->add(new \Criteria('group_type', 'Admin'));
$memberHandler = \xoops_getHandler('member');
$adminXoopsGroups  = $memberHandler->getGroupList($crGroups);
$adminGroups = [];
foreach ($adminXoopsGroups as $key => $adminGroup) {
	$adminGroups[$adminGroup]  = $key;
}
$modversion['config'][] = [
	'name'        => 'admin_groups',
	'title'       => '_MI_WGGITHUB_ADMIN_GROUPS',
	'description' => '_MI_WGGITHUB_ADMIN_GROUPS_DESC',
	'formtype'    => 'select_multi',
	'valuetype'   => 'array',
	'default'     => $adminGroups,
	'options'     => $adminGroups,
];
unset($crGroups);
// Keywords
$modversion['config'][] = [
	'name'        => 'keywords',
	'title'       => '_MI_WGGITHUB_KEYWORDS',
	'description' => '_MI_WGGITHUB_KEYWORDS_DESC',
	'formtype'    => 'textbox',
	'valuetype'   => 'text',
	'default'     => 'wggithub, settings, repositories, directories, requests, readmes',
];
// Admin pager
$modversion['config'][] = [
	'name'        => 'adminpager',
	'title'       => '_MI_WGGITHUB_ADMIN_PAGER',
	'description' => '_MI_WGGITHUB_ADMIN_PAGER_DESC',
	'formtype'    => 'textbox',
	'valuetype'   => 'int',
	'default'     => 25,
];
// User pager
$modversion['config'][] = [
	'name'        => 'userpager',
	'title'       => '_MI_WGGITHUB_USER_PAGER',
	'description' => '_MI_WGGITHUB_USER_PAGER_DESC',
	'formtype'    => 'textbox',
	'valuetype'   => 'int',
	'default'     => 25,
];
// Number column
$modversion['config'][] = [
	'name'        => 'numb_col',
	'title'       => '_MI_WGGITHUB_NUMB_COL',
	'description' => '_MI_WGGITHUB_NUMB_COL_DESC',
	'formtype'    => 'select',
	'valuetype'   => 'int',
	'default'     => 1,
	'options'     => [1 => '1', 2 => '2', 3 => '3', 4 => '4'],
];
// Divide by
$modversion['config'][] = [
	'name'        => 'divideby',
	'title'       => '_MI_WGGITHUB_DIVIDEBY',
	'description' => '_MI_WGGITHUB_DIVIDEBY_DESC',
	'formtype'    => 'select',
	'valuetype'   => 'int',
	'default'     => 1,
	'options'     => [1 => '1', 2 => '2', 3 => '3', 4 => '4'],
];
// Table type
$modversion['config'][] = [
	'name'        => 'table_type',
	'title'       => '_MI_WGGITHUB_TABLE_TYPE',
	'description' => '_MI_WGGITHUB_DIVIDEBY_DESC',
	'formtype'    => 'select',
	'valuetype'   => 'int',
	'default'     => 'bordered',
	'options'     => ['bordered' => 'bordered', 'striped' => 'striped', 'hover' => 'hover', 'condensed' => 'condensed'],
];
// Panel by
$modversion['config'][] = [
	'name'        => 'panel_type',
	'title'       => '_MI_WGGITHUB_PANEL_TYPE',
	'description' => '_MI_WGGITHUB_PANEL_TYPE_DESC',
	'formtype'    => 'select',
	'valuetype'   => 'text',
	'default'     => 'default',
	'options'     => ['default' => 'default', 'primary' => 'primary', 'success' => 'success', 'info' => 'info', 'warning' => 'warning', 'danger' => 'danger'],
];
// Advertise
$modversion['config'][] = [
	'name'        => 'advertise',
	'title'       => '_MI_WGGITHUB_ADVERTISE',
	'description' => '_MI_WGGITHUB_ADVERTISE_DESC',
	'formtype'    => 'textarea',
	'valuetype'   => 'text',
	'default'     => '',
];
// Bookmarks
$modversion['config'][] = [
	'name'        => 'bookmarks',
	'title'       => '_MI_WGGITHUB_BOOKMARKS',
	'description' => '_MI_WGGITHUB_BOOKMARKS_DESC',
	'formtype'    => 'yesno',
	'valuetype'   => 'int',
	'default'     => 0,
];
// Make Sample button visible?
$modversion['config'][] = [
	'name'        => 'displaySampleButton',
	'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON',
	'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC',
	'formtype'    => 'yesno',
	'valuetype'   => 'int',
	'default'     => 1,
];
// Maintained by
$modversion['config'][] = [
	'name'        => 'maintainedby',
	'title'       => '_MI_WGGITHUB_MAINTAINEDBY',
	'description' => '_MI_WGGITHUB_MAINTAINEDBY_DESC',
	'formtype'    => 'textbox',
	'valuetype'   => 'text',
	'default'     => 'https://xoops.org/modules/newbb',
];
