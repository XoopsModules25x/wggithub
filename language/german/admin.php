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
\define('_AM_WGGITHUB_STATISTICS', 'Statistiken');
// There are
\define('_AM_WGGITHUB_THEREARE_SETTINGS', "Es gibt <span class='bold'>%s</span> Einstellungen in der Datenbank");
\define('_AM_WGGITHUB_THEREARE_REPOSITORIES', "Es gibt <span class='bold'>%s</span> Repositories in der Datenbank");
\define('_AM_WGGITHUB_THEREARE_DIRECTORIES', "Es sind <span class='bold'>%s</span> Verzeichnisse vorhanden");
\define('_AM_WGGITHUB_THEREARE_LOGS', "Es gibt <span class='bold'>%s</span> Log-Einträge in der Datenbank");
\define('_AM_WGGITHUB_THEREARE_READMES', "Es sind <span class='bold'>%s</span> Readme-Einträge vorhanden");
\define('_AM_WGGITHUB_THEREARE_RELEASES', "Es gibt <span class='bold'>%s</span> Releases in der Datenbank");
// ---------------- Admin Files ----------------
// There aren't
\define('_AM_WGGITHUB_THEREARENT_SETTINGS', "Es gibt keine Einstellungen");
\define('_AM_WGGITHUB_THEREARENT_REPOSITORIES', "Es gibt keine Repositories");
\define('_AM_WGGITHUB_THEREARENT_REPOSITORIES_FILTER', "Es gibt keine Repositories zu diesem Filter");
\define('_AM_WGGITHUB_THEREARENT_DIRECTORIES', "Es gibt keine Verzeichisse");
\define('_AM_WGGITHUB_THEREARENT_LOGS', "Es gibt keine Log-Einträge");
\define('_AM_WGGITHUB_THEREARENT_READMES', "Es gibt keine Readme-Einträge");
\define('_AM_WGGITHUB_THEREARENT_READMES_FILTER', "Es gibt keine Readme-Einträge zu diesem Filter");
\define('_AM_WGGITHUB_THEREARENT_RELEASES', "Es gibt keine Releases");
\define('_AM_WGGITHUB_THEREARENT_RELEASES_FILTER', "Es gibt keine Releases zu diesem Filter");
// Save/Delete
\define('_AM_WGGITHUB_FORM_OK', 'Erfolgreich gespeichert');
\define('_AM_WGGITHUB_FORM_DELETE_OK', 'Erfolgreich gelöscht');
\define('_AM_WGGITHUB_FORM_SURE_DELETE', "Willst Du <b><span style='color : Red;'>%s </span></b> wirklich löschen?");
\define('_AM_WGGITHUB_FORM_SURE_RENEW', "Willst Du <b><span style='color : Red;'>%s </span></b> wirklich aktualisieren");
\define('_AM_WGGITHUB_FORM_SURE_DELETEALL', "Willst Du die Einträge aus Tabelle <b><span style='color : Red;'>%s </span></b> wirklich löschen");
// Filters
\define('_AM_WGGITHUB_FILTER_TYPE_NONE', 'Filter nicht verwenden');
\define('_AM_WGGITHUB_FILTER_TYPE_ALL', 'Filter für alle verwenden');
\define('_AM_WGGITHUB_FILTER_TYPE_RELEASES', 'Nur Filter Releases verwenden');
\define('_AM_WGGITHUB_FILTER', 'Filter');
\define('_AM_WGGITHUB_FILTER_OPERAND_EQUAL', ' = ');
\define('_AM_WGGITHUB_FILTER_OPERAND_LIKE', ' enthält ');
// Status
\define('_AM_WGGITHUB_STATUS_NONE', 'Nein');
\define('_AM_WGGITHUB_STATUS_NEW', 'Neu');
\define('_AM_WGGITHUB_STATUS_UPTODATE', 'Aktuell');
\define('_AM_WGGITHUB_STATUS_UPDATED', 'Aktualisiert');
\define('_AM_WGGITHUB_STATUS_OFFLINE', 'Offline');
//Change yes/no
\define('_AM_WGGITHUB_SETON', 'AUS, auf AN ändern');
\define('_AM_WGGITHUB_SETOFF', 'AN, auf AUS ändern');
// Buttons
\define('_AM_WGGITHUB_ADD_SETTING', 'Neue Einstellung hinzufügen');
\define('_AM_WGGITHUB_ADD_REPOSITORY', 'Repository hinzufügen');
\define('_AM_WGGITHUB_ADD_DIRECTORY', 'Verzeichnis hinzufügen');
\define('_AM_WGGITHUB_ADD_LOG', 'Neuen Log-Eintrag hinzufügen');
\define('_AM_WGGITHUB_ADD_README', 'Neuen Readme-Eintrag hinzufügen');
\define('_AM_WGGITHUB_ADD_RELEASE', 'Neuen Release-Eintrag hinzufügen');
// Lists
\define('_AM_WGGITHUB_SETTINGS_LIST', 'Liste der Einstellungen');
\define('_AM_WGGITHUB_REPOSITORIES_LIST', 'Liste der Repositories');
\define('_AM_WGGITHUB_DIRECTORIES_LIST', 'Liste der Verzeichnis ');
\define('_AM_WGGITHUB_LOGS_LIST', 'Liste der Log-Einträge');
\define('_AM_WGGITHUB_READMES_LIST', 'Liste der Readme-Einträge');
\define('_AM_WGGITHUB_RELEASES_LIST', 'Liste der Release-Einträge');
// ---------------- Admin Classes ----------------
// Setting add/edit
\define('_AM_WGGITHUB_SETTING_ADD', 'Neue Einstellung hinzufügen');
\define('_AM_WGGITHUB_SETTING_EDIT', 'Einstellung bearbeiten');
// Elements of Setting
\define('_AM_WGGITHUB_SETTING_ID', 'Id');
\define('_AM_WGGITHUB_SETTING_USERNAME', 'Benutzername');
\define('_AM_WGGITHUB_SETTING_TOKEN', 'Token');
\define('_AM_WGGITHUB_SETTING_OPTIONS', 'Optionen');
\define('_AM_WGGITHUB_SETTING_PRIMARY', 'Primär');
\define('_AM_WGGITHUB_SETTING_DATE', 'Datum');
\define('_AM_WGGITHUB_SETTING_SUBMITTER', 'Einsender');
// Repository add/edit
\define('_AM_WGGITHUB_REPOSITORY_ADD', 'Repository hinzufügen');
\define('_AM_WGGITHUB_REPOSITORY_EDIT', 'Repository bearbeiten');
// Elements of Repository
\define('_AM_WGGITHUB_REPOSITORY_ID', 'Id');
\define('_AM_WGGITHUB_REPOSITORY_NODEID', 'Nodeid');
\define('_AM_WGGITHUB_REPOSITORY_USER', 'User');
\define('_AM_WGGITHUB_REPOSITORY_NAME', 'Name');
\define('_AM_WGGITHUB_REPOSITORY_FULLNAME', 'Voller Name');
\define('_AM_WGGITHUB_REPOSITORY_CREATEDAT', 'Erstelldatum');
\define('_AM_WGGITHUB_REPOSITORY_UPDATEDAT', 'Datum Aktualisierung');
\define('_AM_WGGITHUB_REPOSITORY_HTMLURL', 'Html Url');
\define('_AM_WGGITHUB_REPOSITORY_README', 'Liesmich');
\define('_AM_WGGITHUB_REPOSITORY_PRERELEASE', 'Pre-Release');
\define('_AM_WGGITHUB_REPOSITORY_RELEASE', 'Release');
\define('_AM_WGGITHUB_REPOSITORY_APPROVED', 'Freigabe');
\define('_AM_WGGITHUB_REPOSITORY_STATUS', 'Status');
\define('_AM_WGGITHUB_REPOSITORY_DATECREATED', 'Datum erstellt');
\define('_AM_WGGITHUB_REPOSITORY_SUBMITTER', 'Einsender');
// Directory add/edit
\define('_AM_WGGITHUB_DIRECTORY_ADD', 'Verzeichnis hinzufügen');
\define('_AM_WGGITHUB_DIRECTORY_EDIT', 'Verzeichnis bearbeiten');
// Elements of Directory
\define('_AM_WGGITHUB_DIRECTORY_ID', 'Id');
\define('_AM_WGGITHUB_DIRECTORY_NAME', 'Name');
\define('_AM_WGGITHUB_DIRECTORY_DESCR', 'Beschreibung');
\define('_AM_WGGITHUB_DIRECTORY_TYPE', 'Typ');
\define('_AM_WGGITHUB_DIRECTORY_TYPE_USER', 'User');
\define('_AM_WGGITHUB_DIRECTORY_TYPE_ORG', 'Organisation');
\define('_AM_WGGITHUB_DIRECTORY_CONTENT', 'Inhalt');
\define('_AM_WGGITHUB_DIRECTORY_CONTENT_ALL', 'Alle Forks');
\define('_AM_WGGITHUB_DIRECTORY_CONTENT_OWN', 'Nur Forks des Inhabers');
\define('_AM_WGGITHUB_DIRECTORY_AUTOUPDATE', 'Automatische Update');
\define('_AM_WGGITHUB_DIRECTORY_ONLINE', 'Online');
\define('_AM_WGGITHUB_DIRECTORY_FILTERRELEASE', 'Filter Release anwenden');
\define('_AM_WGGITHUB_DIRECTORY_WEIGHT', 'Reihung');
\define('_AM_WGGITHUB_DIRECTORY_DATECREATED', 'Datum erstellt');
\define('_AM_WGGITHUB_DIRECTORY_SUBMITTER', 'Einsender');
// Request add/edit
\define('_AM_WGGITHUB_LOG_ADD', 'Log-Eintrag hinzufügen');
\define('_AM_WGGITHUB_LOG_EDIT', 'Log-Eintrag bearbeiten');
\define('_AM_WGGITHUB_LOG_CLEAR', 'Tabelle leeren');
// Elements of Request
\define('_AM_WGGITHUB_LOG_ID', 'Id');
\define('_AM_WGGITHUB_LOG_TYPE', 'Typ');
\define('_AM_WGGITHUB_LOG_TYPE_NONE', 'Nein');
\define('_AM_WGGITHUB_LOG_TYPE_UPDATE_START', 'Beginn Update');
\define('_AM_WGGITHUB_LOG_TYPE_UPDATE_END', 'Ende Update');
\define('_AM_WGGITHUB_LOG_TYPE_REQUEST', 'Anfrage');
\define('_AM_WGGITHUB_LOG_TYPE_ERROR', 'Fehler');
\define('_AM_WGGITHUB_LOG_DETAILS', 'Details');
\define('_AM_WGGITHUB_LOG_RESULT', 'Ergebnis');
\define('_AM_WGGITHUB_LOG_DATECREATED', 'Datum erstellt');
\define('_AM_WGGITHUB_LOG_SUBMITTER', 'Einsender');
// Readme add/edit
\define('_AM_WGGITHUB_README_ADD', 'Readme-Eintrag hinzufügen');
\define('_AM_WGGITHUB_README_EDIT', 'Readme-Eintrag bearbeiten');
// Elements of Readme
\define('_AM_WGGITHUB_README_ID', 'Id');
\define('_AM_WGGITHUB_README_REPOID', 'Repository');
\define('_AM_WGGITHUB_README_NAME', 'Name');
\define('_AM_WGGITHUB_README_TYPE', 'Typ');
\define('_AM_WGGITHUB_README_CONTENT', 'Inhalt');
\define('_AM_WGGITHUB_README_ENCODING', 'Encoding');
\define('_AM_WGGITHUB_README_DOWNLOADURL', 'Download Url');
\define('_AM_WGGITHUB_README_BASEURL', 'Base url');
\define('_AM_WGGITHUB_README_DATECREATED', 'Datum erstellt');
\define('_AM_WGGITHUB_README_SUBMITTER', 'Einsender');
// Release add/edit
\define('_AM_WGGITHUB_RELEASE_ADD', 'Release-Eintrag hinzufügen');
\define('_AM_WGGITHUB_RELEASE_EDIT', 'Release-Eintrag bearbeiten');
// Elements of Release
\define('_AM_WGGITHUB_RELEASE_ID', 'Id');
\define('_AM_WGGITHUB_RELEASE_REPOID', 'Repository');
\define('_AM_WGGITHUB_RELEASE_TYPE', 'Typ');
\define('_AM_WGGITHUB_RELEASE_PRERELEASE', 'Prerelease');
\define('_AM_WGGITHUB_RELEASE_NAME', 'Name');
\define('_AM_WGGITHUB_RELEASE_PUBLISHEDAT', 'Veröffentlicht am');
\define('_AM_WGGITHUB_RELEASE_TARBALLURL', 'Tarball Url');
\define('_AM_WGGITHUB_RELEASE_ZIPBALLURL', 'Zipball Url');
\define('_AM_WGGITHUB_RELEASE_DATECREATED', 'Datum erstellt');
\define('_AM_WGGITHUB_RELEASE_SUBMITTER', 'Einsender');
// General
\define('_AM_WGGITHUB_FORM_UPLOAD', 'Datei hochladen');
\define('_AM_WGGITHUB_FORM_UPLOAD_NEW', 'Neue Datei hochladen:');
\define('_AM_WGGITHUB_FORM_UPLOAD_SIZE', 'Maximale Dateigröße:');
\define('_AM_WGGITHUB_FORM_UPLOAD_SIZE_MB', 'MB');
\define('_AM_WGGITHUB_FORM_UPLOAD_IMG_WIDTH', 'Maximale Bildbreite:');
\define('_AM_WGGITHUB_FORM_UPLOAD_IMG_HEIGHT', 'Maximale Bildhöhe:');
\define('_AM_WGGITHUB_FORM_IMAGE_PATH', 'Dateien in %s :');
\define('_AM_WGGITHUB_FORM_ACTION', 'Aktion');
\define('_AM_WGGITHUB_FORM_EDIT', 'Ändern');
\define('_AM_WGGITHUB_FORM_DELETE', 'Löschen');
// Errors
\define('_AM_WGGITHUB_ERROR_DELETE_DATA', 'Fehler beim Löschen der Daten von:');
// ---------------- Admin Permissions ----------------
// Permissions
\define('_AM_WGGITHUB_PERMISSIONS_GLOBAL', 'Globale Berechtigungen');
\define('_AM_WGGITHUB_PERMISSIONS_GLOBAL_DESC', 'Globale Berechtigung für die verschiedenen Gruppen festlegen');
\define('_AM_WGGITHUB_PERMISSIONS_GLOBAL_VIEW', 'Berechtigung zum Ansehen');
\define('_AM_WGGITHUB_PERMISSIONS_GLOBAL_READ', 'Berechtigung zum Lesen neuer Daten von Github');
\define('_AM_WGGITHUB_PERMISSIONS_README_UPDATE', 'Berechtigung zum Aktualisieren bestehender Readme-Einträge von Github');
\define('_AM_WGGITHUB_NO_PERMISSIONS_SET', 'Keine Berechtigung gesetzt');
// ---------------- Admin Others ----------------
\define('_AM_WGGITHUB_ABOUT_MAKE_DONATION', 'Einsenden');
\define('_AM_WGGITHUB_SUPPORT_FORUM', 'Support Forum');
\define('_AM_WGGITHUB_DONATION_AMOUNT', 'Spendenbetrag');
\define('_AM_WGGITHUB_MAINTAINEDBY', ' wird unterstützt von ');
// ---------------- End ----------------
