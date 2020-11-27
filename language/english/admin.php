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

include_once __DIR__ . '/common.php';
include_once __DIR__ . '/main.php';

// ---------------- Admin Index ----------------
\define('_AM_WGGITHUB_STATISTICS', 'Statistics');
// There are
\define('_AM_WGGITHUB_THEREARE_SETTINGS', "There are <span class='bold'>%s</span> settings in the database");
\define('_AM_WGGITHUB_THEREARE_REPOSITORIES', "There are <span class='bold'>%s</span> repositories in the database");
\define('_AM_WGGITHUB_THEREARE_DIRECTORIES', "There are <span class='bold'>%s</span> directories in the database");
\define('_AM_WGGITHUB_THEREARE_REQUESTS', "There are <span class='bold'>%s</span> requests in the database");
\define('_AM_WGGITHUB_THEREARE_READMES', "There are <span class='bold'>%s</span> readmes in the database");
\define('_AM_WGGITHUB_THEREARE_RELEASES', "There are <span class='bold'>%s</span> releases in the database");
// ---------------- Admin Files ----------------
// There aren't
\define('_AM_WGGITHUB_THEREARENT_SETTINGS', "There aren't settings");
\define('_AM_WGGITHUB_THEREARENT_REPOSITORIES', "There aren't repositories");
\define('_AM_WGGITHUB_THEREARENT_DIRECTORIES', "There aren't directories");
\define('_AM_WGGITHUB_THEREARENT_REQUESTS', "There aren't requests");
\define('_AM_WGGITHUB_THEREARENT_READMES', "There aren't readmes");
\define('_AM_WGGITHUB_THEREARENT_RELEASES', "There aren't releases");
// Save/Delete
\define('_AM_WGGITHUB_FORM_OK', 'Successfully saved');
\define('_AM_WGGITHUB_FORM_DELETE_OK', 'Successfully deleted');
\define('_AM_WGGITHUB_FORM_SURE_DELETE', "Are you sure to delete: <b><span style='color : Red;'>%s </span></b>");
\define('_AM_WGGITHUB_FORM_SURE_RENEW', "Are you sure to update: <b><span style='color : Red;'>%s </span></b>");
// Status
\define('_AM_WGGITHUB_STATUS_NONE', 'NONE');
\define('_AM_WGGITHUB_STATUS_NEW', 'New');
\define('_AM_WGGITHUB_STATUS_UPTODATE', 'Up to date');
\define('_AM_WGGITHUB_STATUS_UPDATED', 'Updated');
// Buttons
\define('_AM_WGGITHUB_ADD_SETTING', 'Add New Setting');
\define('_AM_WGGITHUB_ADD_REPOSITORY', 'Add New Repository');
\define('_AM_WGGITHUB_ADD_DIRECTORY', 'Add New Directory');
\define('_AM_WGGITHUB_ADD_REQUEST', 'Add New Request');
\define('_AM_WGGITHUB_ADD_README', 'Add New Readme');
\define('_AM_WGGITHUB_ADD_RELEASE', 'Add New Release');
// Lists
\define('_AM_WGGITHUB_SETTINGS_LIST', 'List of Settings');
\define('_AM_WGGITHUB_REPOSITORIES_LIST', 'List of Repositories');
\define('_AM_WGGITHUB_DIRECTORIES_LIST', 'List of Directories');
\define('_AM_WGGITHUB_REQUESTS_LIST', 'List of Requests');
\define('_AM_WGGITHUB_READMES_LIST', 'List of Readmes');
\define('_AM_WGGITHUB_RELEASES_LIST', 'List of Releases');
// ---------------- Admin Classes ----------------
// Setting add/edit
\define('_AM_WGGITHUB_SETTING_ADD', 'Add Setting');
\define('_AM_WGGITHUB_SETTING_EDIT', 'Edit Setting');
// Elements of Setting
\define('_AM_WGGITHUB_SETTING_ID', 'Id');
\define('_AM_WGGITHUB_SETTING_USERNAME', 'Username');
\define('_AM_WGGITHUB_SETTING_TOKEN', 'Token');
\define('_AM_WGGITHUB_SETTING_OPTIONS', 'Options');
\define('_AM_WGGITHUB_SETTING_PRIMARY', 'Primary');
\define('_AM_WGGITHUB_SETTING_DATE', 'Date');
\define('_AM_WGGITHUB_SETTING_SUBMITTER', 'Submitter');
// Repository add/edit
\define('_AM_WGGITHUB_REPOSITORY_ADD', 'Add Repository');
\define('_AM_WGGITHUB_REPOSITORY_EDIT', 'Edit Repository');
// Elements of Repository
\define('_AM_WGGITHUB_REPOSITORY_ID', 'Id');
\define('_AM_WGGITHUB_REPOSITORY_NODEID', 'Nodeid');
\define('_AM_WGGITHUB_REPOSITORY_USER', 'User');
\define('_AM_WGGITHUB_REPOSITORY_NAME', 'Name');
\define('_AM_WGGITHUB_REPOSITORY_FULLNAME', 'Fullname');
\define('_AM_WGGITHUB_REPOSITORY_CREATEDAT', 'Createdat');
\define('_AM_WGGITHUB_REPOSITORY_UPDATEDAT', 'Updatedat');
\define('_AM_WGGITHUB_REPOSITORY_HTMLURL', 'Htmlurl');
\define('_AM_WGGITHUB_REPOSITORY_README', 'Readme');
\define('_AM_WGGITHUB_REPOSITORY_PRERELEASE', 'Pre-Release');
\define('_AM_WGGITHUB_REPOSITORY_RELEASE', 'Release');
\define('_AM_WGGITHUB_REPOSITORY_STATUS', 'Status');
\define('_AM_WGGITHUB_REPOSITORY_DATECREATED', 'Datecreated');
\define('_AM_WGGITHUB_REPOSITORY_SUBMITTER', 'Submitter');
// Directory add/edit
\define('_AM_WGGITHUB_DIRECTORY_ADD', 'Add Directory');
\define('_AM_WGGITHUB_DIRECTORY_EDIT', 'Edit Directory');
// Elements of Directory
\define('_AM_WGGITHUB_DIRECTORY_ID', 'Id');
\define('_AM_WGGITHUB_DIRECTORY_NAME', 'Name');
\define('_AM_WGGITHUB_DIRECTORY_TYPE', 'Type');
\define('_AM_WGGITHUB_DIRECTORY_TYPE_USER', 'User');
\define('_AM_WGGITHUB_DIRECTORY_TYPE_ORG', 'Organisation');
\define('_AM_WGGITHUB_DIRECTORY_AUTOUPDATE', 'Autoupdate');
\define('_AM_WGGITHUB_DIRECTORY_ONLINE', 'Online');
\define('_AM_WGGITHUB_DIRECTORY_FILTERRELEASE', 'Apply Filter Release');
\define('_AM_WGGITHUB_DIRECTORY_DATECREATED', 'Datecreated');
\define('_AM_WGGITHUB_DIRECTORY_SUBMITTER', 'Submitter');
// Request add/edit
\define('_AM_WGGITHUB_REQUEST_ADD', 'Add Request');
\define('_AM_WGGITHUB_REQUEST_EDIT', 'Edit Request');
// Elements of Request
\define('_AM_WGGITHUB_REQUEST_ID', 'Id');
\define('_AM_WGGITHUB_REQUEST_REQUEST', 'Request');
\define('_AM_WGGITHUB_REQUEST_RESULT', 'Result');
\define('_AM_WGGITHUB_REQUEST_DATECREATED', 'Datecreated');
\define('_AM_WGGITHUB_REQUEST_SUBMITTER', 'Submitter');
// Readme add/edit
\define('_AM_WGGITHUB_README_ADD', 'Add Readme');
\define('_AM_WGGITHUB_README_EDIT', 'Edit Readme');
// Elements of Readme
\define('_AM_WGGITHUB_README_ID', 'Id');
\define('_AM_WGGITHUB_README_REPOID', 'Repository');
\define('_AM_WGGITHUB_README_NAME', 'Name');
\define('_AM_WGGITHUB_README_TYPE', 'Type');
\define('_AM_WGGITHUB_README_CONTENT', 'Content');
\define('_AM_WGGITHUB_README_ENCODING', 'Encoding');
\define('_AM_WGGITHUB_README_DOWNLOADURL', 'Download url');
\define('_AM_WGGITHUB_README_DATECREATED', 'Datecreated');
\define('_AM_WGGITHUB_README_SUBMITTER', 'Submitter');
// Release add/edit
\define('_AM_WGGITHUB_RELEASE_ADD', 'Add Release');
\define('_AM_WGGITHUB_RELEASE_EDIT', 'Edit Release');
// Elements of Release
\define('_AM_WGGITHUB_RELEASE_ID', 'Id');
\define('_AM_WGGITHUB_RELEASE_REPOID', 'Repository');
\define('_AM_WGGITHUB_RELEASE_TYPE', 'Type');
\define('_AM_WGGITHUB_RELEASE_PRERELEASE', 'Prerelease');
\define('_AM_WGGITHUB_RELEASE_NAME', 'Name');
\define('_AM_WGGITHUB_RELEASE_PUBLISHEDAT', 'Publishedat');
\define('_AM_WGGITHUB_RELEASE_TARBALLURL', 'Tarballurl');
\define('_AM_WGGITHUB_RELEASE_ZIPBALLURL', 'Zipballurl');
\define('_AM_WGGITHUB_RELEASE_DATECREATED', 'Datecreated');
\define('_AM_WGGITHUB_RELEASE_SUBMITTER', 'Submitter');
// General
\define('_AM_WGGITHUB_FORM_UPLOAD', 'Upload file');
\define('_AM_WGGITHUB_FORM_UPLOAD_NEW', 'Upload new file: ');
\define('_AM_WGGITHUB_FORM_UPLOAD_SIZE', 'Max file size: ');
\define('_AM_WGGITHUB_FORM_UPLOAD_SIZE_MB', 'MB');
\define('_AM_WGGITHUB_FORM_UPLOAD_IMG_WIDTH', 'Max image width: ');
\define('_AM_WGGITHUB_FORM_UPLOAD_IMG_HEIGHT', 'Max image height: ');
\define('_AM_WGGITHUB_FORM_IMAGE_PATH', 'Files in %s :');
\define('_AM_WGGITHUB_FORM_ACTION', 'Action');
\define('_AM_WGGITHUB_FORM_EDIT', 'Modification');
\define('_AM_WGGITHUB_FORM_DELETE', 'Clear');
// ---------------- Admin Permissions ----------------
// Permissions
\define('_AM_WGGITHUB_PERMISSIONS_GLOBAL', 'Global permissions');
\define('_AM_WGGITHUB_PERMISSIONS_GLOBAL_DESC', 'Set global permissions global for different groups');
\define('_AM_WGGITHUB_PERMISSIONS_GLOBAL_VIEW', 'Permissions to view');
\define('_AM_WGGITHUB_PERMISSIONS_GLOBAL_READ', 'Permissions to read new data from GitHub');
\define('_AM_WGGITHUB_PERMISSIONS_README_UPDATE', 'Permissions to update existing readme with data from GitHub');
\define('_AM_WGGITHUB_NO_PERMISSIONS_SET', 'No permission set');
// ---------------- Admin Others ----------------
\define('_AM_WGGITHUB_ABOUT_MAKE_DONATION', 'Submit');
\define('_AM_WGGITHUB_SUPPORT_FORUM', 'Support Forum');
\define('_AM_WGGITHUB_DONATION_AMOUNT', 'Donation Amount');
\define('_AM_WGGITHUB_MAINTAINEDBY', ' is maintained by ');
// ---------------- End ----------------
