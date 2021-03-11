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
\define('_MA_WGGITHUB_INDEX', 'Übersicht');
\define('_MA_WGGITHUB_TITLE', 'wgGitHub');
\define('_MA_WGGITHUB_DESC', 'wgGitHub - GitHub-Viewer für XOOPS');
\define('_MA_WGGITHUB_INDEX_DESC', 'Willkommen bei wgGitHub - dem GitHub-Viewer für XOOPS!
<br>Auf den verschiedenen Tabs siehst Du einige XOOPS-Repositories auf GitHub.
<br>Neben den grundsätzlichen Informationen wie das Erstell- oder Aktualisierungsdatum wird auch der Inhalt der Readme-Datei angezeigt (sofern eine vorhanden ist). 
<br>Zusätzlich findest Du aber auch Schaltflächen für den direkten Download der verfügbaren letzten Releases.
<br><br>Viel Spaß beim Entdecken der Welt von XOOPS.');
\define('_MA_WGGITHUB_INDEX_LASTUPDATE', 'Letztes Update');
\define('_MA_WGGITHUB_INDEX_UPTODATE', 'Alle Informationen sind aktuell');
\define('_MA_WGGITHUB_NO_PDF_LIBRARY', 'TCPDF-Libraries sind nicht vorhanden, bitte auf root/Frameworks hochladen');
\define('_MA_WGGITHUB_NO', 'Nein');
\define('_MA_WGGITHUB_DETAILS', 'Details anzeigen');
\define('_MA_WGGITHUB_BROKEN', 'Als fehlerhaft melden');
// ---------------- Filter ----------------
\define('_MA_WGGITHUB_FILTER_RELEASE', 'Nach Release filtern');
\define('_MA_WGGITHUB_FILTER_RELEASE_FINAL', 'Nur Finals');
\define('_MA_WGGITHUB_FILTER_RELEASE_ANY', 'Alle Releases');
\define('_MA_WGGITHUB_FILTER_RELEASE_ALL', 'Alle (auch jene ohne Release)');
\define('_MA_WGGITHUB_FILTER_SORTBY', 'Sortiert nach');
\define('_MA_WGGITHUB_FILTER_SORTBY_NAME', 'Name');
\define('_MA_WGGITHUB_FILTER_SORTBY_UPDATE', 'Letzte Aktualisierung');
// ---------------- Contents ----------------
// Repository
\define('_MA_WGGITHUB_REPOSITORY', 'Repository');
\define('_MA_WGGITHUB_REPOSITORIES', 'Repositories');
\define('_MA_WGGITHUB_REPOSITORIES_TITLE', 'Titel Repositories');
\define('_MA_WGGITHUB_REPOSITORIES_DESC', 'Beschreibung Repositories');
\define('_MA_WGGITHUB_REPOSITORIES_LIST', 'Liste der Repositories');
\define('_MA_WGGITHUB_REPOSITORY_GOTO', 'Gehe zu GitHub Repository');
\define('_MA_WGGITHUB_REPOSITORIES_COUNT1', 'Verzeichnis %s: %r von %t Repositories');
\define('_MA_WGGITHUB_REPOSITORIES_COUNT2', 'Verzeichnis %s: %t Repositories');
// Caption of Repository
\define('_MA_WGGITHUB_REPOSITORY_ID', 'Id');
\define('_MA_WGGITHUB_REPOSITORY_NODEID', 'Nodeid');
\define('_MA_WGGITHUB_REPOSITORY_NAME', 'Name');
\define('_MA_WGGITHUB_REPOSITORY_FULLNAME', 'Voller Name');
\define('_MA_WGGITHUB_REPOSITORY_CREATEDAT', 'Erstellt am');
\define('_MA_WGGITHUB_REPOSITORY_UPDATEDAT', 'Aktualisiert am');
\define('_MA_WGGITHUB_REPOSITORY_HTMLURL', 'Html Url');
\define('_MA_WGGITHUB_REPOSITORY_README', 'Liesmich');
\define('_MA_WGGITHUB_REPOSITORY_DATECREATED', 'Erstelldatum');
\define('_MA_WGGITHUB_REPOSITORY_SUBMITTER', 'Einsender');
// Directory
\define('_MA_WGGITHUB_DIRECTORY', 'Verzeichnis');
\define('_MA_WGGITHUB_DIRECTORIES', 'Verzeichnisse');
\define('_MA_WGGITHUB_DIRECTORIES_TITLE', 'Titel Verzeichnisse');
\define('_MA_WGGITHUB_DIRECTORIES_DESC', 'Beschreibung Verzeichnisse');
\define('_MA_WGGITHUB_DIRECTORIES_LIST', 'Liste der Verzeichnis ');
// Caption of Directory
\define('_MA_WGGITHUB_DIRECTORY_ID', 'Id');
\define('_MA_WGGITHUB_DIRECTORY_NAME', 'Name');
\define('_MA_WGGITHUB_DIRECTORY_DESCR', 'Beschreibung');
\define('_MA_WGGITHUB_DIRECTORY_TYPE', 'Typ');
\define('_MA_WGGITHUB_DIRECTORY_DATECREATED', 'Datum erstellt');
\define('_MA_WGGITHUB_DIRECTORY_SUBMITTER', 'Einsender');
\define('_MA_WGGITHUB_DIRECTORY_UPDATE', 'Verzeichnis aktualisieren');
// Readme
\define('_MA_WGGITHUB_README', 'Liesmich');
\define('_MA_WGGITHUB_READMES', 'Readme-Einträge');
\define('_MA_WGGITHUB_READMES_TITLE', 'Titel Readme-Eintrag');
\define('_MA_WGGITHUB_READMES_DESC', 'Bescheibung Readme-Eintrag');
\define('_MA_WGGITHUB_READMES_LIST', 'Liste der Readme-Einträge');
\define('_MA_WGGITHUB_README_NOFILE', 'Es tut uns leid. Es ist kein Readme verfügbar');
\define('_MA_WGGITHUB_README_UPDATE', 'Readme-Eintrag aktualisieren');
// Caption of Readme
\define('_MA_WGGITHUB_README_ID', 'Id');
\define('_MA_WGGITHUB_README_NAME', 'Name');
\define('_MA_WGGITHUB_README_TYPE', 'Typ');
\define('_MA_WGGITHUB_README_CONTENT', 'Inhalt');
\define('_MA_WGGITHUB_README_DATECREATED', 'Datum erstellt');
\define('_MA_WGGITHUB_README_SUBMITTER', 'Einsender');
\define('_MA_WGGITHUB_INDEX_THEREARE', 'Es gibt %s Readme-Einträge');
\define('_MA_WGGITHUB_INDEX_LATEST_LIST', 'Letzte Einträge auf wgGitHub');
// Readme
\define('_MA_WGGITHUB_RELEASES', 'Releases');
\define('_MA_WGGITHUB_RELEASE_ZIP', 'Zip');
\define('_MA_WGGITHUB_RELEASE_TAR', 'Tar');
// Read data from Github
\define('_MA_WGGITHUB_READGH_DIRECTORY', 'Dieses Verzeichnis von GitHub einlesen');
\define('_MA_WGGITHUB_READGH_SUCCESS', 'Das Laden der Daten von GitHub wurde erfolgreich abgeschlossen');
\define('_MA_WGGITHUB_READGH_ERROR_INSERTREQ', 'Fehler beim Speichern des Request für Lesen der Daten von GitHub');
\define('_MA_WGGITHUB_READGH_ERROR_API', 'Fehler beim Datenaustausch mit GitHub');
\define('_MA_WGGITHUB_READGH_ERROR_API_401', 'Fehler beim Datenaustausch mit GitHub: Nicht authorisiert');
\define('_MA_WGGITHUB_READGH_ERROR_API_403', 'Fehler beim Datenaustausch mit GitHub: Zugriff nicht erlaubt');
\define('_MA_WGGITHUB_READGH_ERROR_API_404', 'Fehler beim Datenaustausch mit GitHub: Datei nicht gefunden');
\define('_MA_WGGITHUB_READGH_ERROR_API_405', 'Fehler beim Datenaustausch mit GitHub: Ungültige Methode');
\define('_MA_WGGITHUB_READGH_ERROR_APILIMIT', 'Achtung:<br>Normalerweise werden die Daten automatisch von GitHub geladen, jedoch ist momentan das maximale Limit an API-Anfrage bereits erreicht!<br>Du siehst die Daten vom letzten erfolgreichen Einlesen der Daten von GitHub - die Daten sind daher vielleicht nicht alle aktuell.<br>Wenn Du später wieder vorbei schaust dann sollten die Daten wieder aktuell sein');
\define('_MA_WGGITHUB_READGH_ERROR_APIOTHER', 'Achtung:<br>Normalerweise werden die Daten automatisch von GitHub geladen, jedoch ist die letzte API-Anfrage fehlgeschlagen!<br>Du siehst die Daten vom letzten erfolgreichen Einlesen der Daten von GitHub - die Daten sind daher vielleicht nicht alle aktuell.<br>Wenn Du später wieder vorbei schaust dann sollten die Daten wieder aktuell sein');
// Gitbook
\define('_MA_WGGITHUB_GITBOOK_GOTO', 'Gehe zu GitBook');
// Admin link
\define('_MA_WGGITHUB_ADMIN', 'Administrator');
// ---------------- End ----------------
