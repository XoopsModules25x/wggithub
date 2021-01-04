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

include_once __DIR__ . '/admin.php';

// ---------------- Main ----------------
\define('_MA_WGGITHUB_INDEX', 'Home');
\define('_MA_WGGITHUB_TITLE', 'wgGitHub');
\define('_MA_WGGITHUB_DESC', 'wgGitHub - GitHub-Viewer for XOOPS');
\define('_MA_WGGITHUB_INDEX_DESC', 'Welcome to wgGitHub - GitHub-Viewer for XOOPS!
<br>On the various tabs you can see the XOOPS-repositories on GitHub.
<br>Besides basic information like date of creation or update you can see the content of readme file (if available). 
<br>Additional you can find also a button to download last releases.
<br><br>Have fun with exploring the world of XOOPS.');
\define('_MA_WGGITHUB_INDEX_LASTUPDATE', 'Last update');
\define('_MA_WGGITHUB_INDEX_UPTODATE', 'All information are up to date');
\define('_MA_WGGITHUB_NO_PDF_LIBRARY', 'Libraries TCPDF not there yet, upload them in root/Frameworks');
\define('_MA_WGGITHUB_NO', 'No');
\define('_MA_WGGITHUB_DETAILS', 'Show details');
\define('_MA_WGGITHUB_BROKEN', 'Notify broken');
// ---------------- Filter ----------------
\define('_MA_WGGITHUB_FILTER_RELEASE', 'Filter by release');
\define('_MA_WGGITHUB_FILTER_RELEASE_FINAL', 'Only final');
\define('_MA_WGGITHUB_FILTER_RELEASE_ANY', 'Any release');
\define('_MA_WGGITHUB_FILTER_RELEASE_ALL', 'All (not released included)');
\define('_MA_WGGITHUB_FILTER_SORTBY', 'Sort by');
\define('_MA_WGGITHUB_FILTER_SORTBY_NAME', 'Name');
\define('_MA_WGGITHUB_FILTER_SORTBY_UPDATE', 'Last Update');
// ---------------- Contents ----------------
// Repository
\define('_MA_WGGITHUB_REPOSITORY', 'Repository');
\define('_MA_WGGITHUB_REPOSITORIES', 'Repositories');
\define('_MA_WGGITHUB_REPOSITORIES_TITLE', 'Repositories title');
\define('_MA_WGGITHUB_REPOSITORIES_DESC', 'Repositories description');
\define('_MA_WGGITHUB_REPOSITORIES_LIST', 'List of Repositories');
\define('_MA_WGGITHUB_REPOSITORY_GOTO', 'Goto GitHub Repository');
\define('_MA_WGGITHUB_REPOSITORIES_COUNT1', 'Directory %s: %r of %t Repositories');
\define('_MA_WGGITHUB_REPOSITORIES_COUNT2', 'Directory %s: %t Repositories');
// Caption of Repository
\define('_MA_WGGITHUB_REPOSITORY_ID', 'Id');
\define('_MA_WGGITHUB_REPOSITORY_NODEID', 'Nodeid');
\define('_MA_WGGITHUB_REPOSITORY_NAME', 'Name');
\define('_MA_WGGITHUB_REPOSITORY_FULLNAME', 'Fullname');
\define('_MA_WGGITHUB_REPOSITORY_CREATEDAT', 'Created at');
\define('_MA_WGGITHUB_REPOSITORY_UPDATEDAT', 'Updated at');
\define('_MA_WGGITHUB_REPOSITORY_HTMLURL', 'Html url');
\define('_MA_WGGITHUB_REPOSITORY_README', 'Readme');
\define('_MA_WGGITHUB_REPOSITORY_DATECREATED', 'Date created');
\define('_MA_WGGITHUB_REPOSITORY_SUBMITTER', 'Submitter');
// Directory
\define('_MA_WGGITHUB_DIRECTORY', 'Directory');
\define('_MA_WGGITHUB_DIRECTORIES', 'Directories');
\define('_MA_WGGITHUB_DIRECTORIES_TITLE', 'Directories title');
\define('_MA_WGGITHUB_DIRECTORIES_DESC', 'Directories description');
\define('_MA_WGGITHUB_DIRECTORIES_LIST', 'List of directories');
// Caption of Directory
\define('_MA_WGGITHUB_DIRECTORY_ID', 'Id');
\define('_MA_WGGITHUB_DIRECTORY_NAME', 'Name');
\define('_MA_WGGITHUB_DIRECTORY_DESCR', 'Description');
\define('_MA_WGGITHUB_DIRECTORY_TYPE', 'Type');
\define('_MA_WGGITHUB_DIRECTORY_DATECREATED', 'Datecreated');
\define('_MA_WGGITHUB_DIRECTORY_SUBMITTER', 'Submitter');
\define('_MA_WGGITHUB_DIRECTORY_UPDATE', 'Update Directory');
// Readme
\define('_MA_WGGITHUB_README', 'Readme');
\define('_MA_WGGITHUB_READMES', 'Readmes');
\define('_MA_WGGITHUB_READMES_TITLE', 'Readmes title');
\define('_MA_WGGITHUB_READMES_DESC', 'Readmes description');
\define('_MA_WGGITHUB_READMES_LIST', 'List of Readmes');
\define('_MA_WGGITHUB_README_NOFILE', 'Sorry - there is no readme file available');
\define('_MA_WGGITHUB_README_UPDATE', 'Update Readme');
// Caption of Readme
\define('_MA_WGGITHUB_README_ID', 'Id');
\define('_MA_WGGITHUB_README_NAME', 'Name');
\define('_MA_WGGITHUB_README_TYPE', 'Type');
\define('_MA_WGGITHUB_README_CONTENT', 'Content');
\define('_MA_WGGITHUB_README_DATECREATED', 'Datecreated');
\define('_MA_WGGITHUB_README_SUBMITTER', 'Submitter');
\define('_MA_WGGITHUB_INDEX_THEREARE', 'There are %s Readmes');
\define('_MA_WGGITHUB_INDEX_LATEST_LIST', 'Last wgGitHub');
// Readme
\define('_MA_WGGITHUB_RELEASES', 'Releases');
\define('_MA_WGGITHUB_RELEASE_ZIP', 'Zip');
\define('_MA_WGGITHUB_RELEASE_TAR', 'Tar');
// Read data from Github
\define('_MA_WGGITHUB_READGH_DIRECTORY', 'Read this directory from GitHub');
\define('_MA_WGGITHUB_READGH_SUCCESS', 'Loading data from GitHub successfully finished');
\define('_MA_WGGITHUB_READGH_ERROR_INSERTREQ', 'Error saving request when loading data from GitHub');
\define('_MA_WGGITHUB_READGH_ERROR_API', 'Error exchange data with GitHub');
\define('_MA_WGGITHUB_READGH_ERROR_API_401', 'Error exchange data with GitHub: Unauthorized');
\define('_MA_WGGITHUB_READGH_ERROR_API_403', 'Error exchange data with GitHub: Forbidden');
\define('_MA_WGGITHUB_READGH_ERROR_API_404', 'Error exchange data with GitHub: file not found');
\define('_MA_WGGITHUB_READGH_ERROR_API_405', 'Error exchange data with GitHub: method not allowed');
\define('_MA_WGGITHUB_READGH_ERROR_APILIMIT', 'Attention:<br>Basically all data are updated automatically, but currently API limit is reached!<br>You see data of last successful load from GitHub - maybe data are not up to date.<br>If you come back in a short time everything should be again up to date');
\define('_MA_WGGITHUB_READGH_ERROR_APIOTHER', 'Attention:<br>Basically all data are updated automatically, but last API call failed!<br>You see data of last successful load from GitHub - maybe data are not up to date.<br>If you come back in a short time everything should be again up to date');
// Gitbook
\define('_MA_WGGITHUB_GITBOOK_GOTO', 'Goto GitBook');
// Admin link
\define('_MA_WGGITHUB_ADMIN', 'Admin');
// ---------------- End ----------------
