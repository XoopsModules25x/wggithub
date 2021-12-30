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
use XoopsModules\Wggithub\Common;

include_once \dirname(__DIR__) . '/preloads/autoloader.php';
require __DIR__ . '/header.php';

// Template Index
$templateMain = 'wggithub_admin_index.tpl';

$op = Request::getCmd('op', 'list');
if ('api_error' == $op) {
    $GLOBALS['xoopsTpl']->assign('error', Request::getString('message'));
}

// Count elements
$countSettings = $settingsHandler->getCount();
$countDirectories = $directoriesHandler->getCount();
$countLogs = $logsHandler->getCount();
$countRepositories = $repositoriesHandler->getCount();
$countReadmes = $readmesHandler->getCount();
$countReleases = $releasesHandler->getCount();

// InfoBox Statistics
$adminObject->addInfoBox(\_AM_WGGITHUB_STATISTICS);
// Info elements
$adminObject->addInfoBoxLine(\sprintf( '<label>' . \_AM_WGGITHUB_THEREARE_SETTINGS . '</label>', $countSettings));
$adminObject->addInfoBoxLine(\sprintf( '<label>' . \_AM_WGGITHUB_THEREARE_DIRECTORIES . '</label>', $countDirectories));
$adminObject->addInfoBoxLine(\sprintf( '<label>' . \_AM_WGGITHUB_THEREARE_LOGS . '</label>', $countLogs));
$adminObject->addInfoBoxLine(\sprintf( '<label>' . \_AM_WGGITHUB_THEREARE_REPOSITORIES . '</label>', $countRepositories));
$adminObject->addInfoBoxLine(\sprintf( '<label>' . \_AM_WGGITHUB_THEREARE_READMES . '</label>', $countReadmes));
$adminObject->addInfoBoxLine(\sprintf( '<label>' . \_AM_WGGITHUB_THEREARE_RELEASES . '</label>', $countReleases));

// Upload Folders
$configurator = new Common\Configurator();
if ($configurator->uploadFolders && \is_array($configurator->uploadFolders)) {
    foreach (\array_keys($configurator->uploadFolders) as $i) {
        $folder[] = $configurator->uploadFolders[$i];
    }
}
// Uploads Folders Created
foreach (\array_keys($folder) as $i) {
    $adminObject->addConfigBoxLine($folder[$i], 'folder');
    $adminObject->addConfigBoxLine([$folder[$i], '777'], 'chmod');
}

// Render Index
$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('index.php'));
// Test Data
if ($helper->getConfig('displaySampleButton')) {
    \xoops_loadLanguage('admin/modulesadmin', 'system');
    include_once \dirname(__DIR__) . '/testdata/index.php';
    $adminObject->addItemButton(\constant('CO_' . $moduleDirNameUpper . '_ADD_SAMPLEDATA'), '__DIR__ . /../../testdata/index.php?op=load', 'add');
    $adminObject->addItemButton(\constant('CO_' . $moduleDirNameUpper . '_SAVE_SAMPLEDATA'), '__DIR__ . /../../testdata/index.php?op=save', 'add');
//    $adminObject->addItemButton(\constant('CO_' . $moduleDirNameUpper . '_EXPORT_SCHEMA'), '__DIR__ . /../../testdata/index.php?op=exportschema', 'add');
    $adminObject->displayButton('left');
}
$GLOBALS['xoopsTpl']->assign('index', $adminObject->displayIndex());
// End Test Data
require __DIR__ . '/footer.php';
