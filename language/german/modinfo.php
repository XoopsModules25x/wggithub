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
\define('_MI_WGGITHUB_DESC', 'Dieses Modul dient zum Download von Sprachpaketen von Transifex');
// ---------------- Admin Menu ----------------
\define('_MI_WGGITHUB_ADMENU1', 'Übersicht');
\define('_MI_WGGITHUB_ADMENU2', 'Einstellungen');
\define('_MI_WGGITHUB_ADMENU3', 'Verzeichnisse');
\define('_MI_WGGITHUB_ADMENU4', 'Logs');
\define('_MI_WGGITHUB_ADMENU5', 'Repositories');
\define('_MI_WGGITHUB_ADMENU6', 'Readme-Einträge');
\define('_MI_WGGITHUB_ADMENU7', 'Releases');
\define('_MI_WGGITHUB_ADMENU8', 'Festlegung Berechtigungen');
\define('_MI_WGGITHUB_ADMENU9', 'Feedback');
\define('_MI_WGGITHUB_ABOUT', 'About');
// ---------------- Admin Nav ----------------
\define('_MI_WGGITHUB_ADMIN_PAGER', 'Admin Listenzeilen');
\define('_MI_WGGITHUB_ADMIN_PAGER_DESC', 'Anzahl der Zeilen für Listen im Admin-Bereich');
// User
\define('_MI_WGGITHUB_USER_PAGER', 'User Listenzeilen');
\define('_MI_WGGITHUB_USER_PAGER_DESC', 'Anzahl der Zeilen für Listen im Mitglieder-Bereich');
// Blocks
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK', 'Block Repositories');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_DESC', 'Beschreibung Block Repositories');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_REPOSITORY', 'Block Repositories');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_REPOSITORY_DESC', 'Beschreibung Block Repositories');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_LAST', 'Block letzte Repositories');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_LAST_DESC', 'Beschreibung Block letzte Repositories');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_NEW', 'Block neue Repositories');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_NEW_DESC', 'Beschreibung Block neue Repositories');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_HITS', 'Block Repositories Hits');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_HITS_DESC', 'Beschreibung Block Repositories Hits');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_TOP', 'Block Repositories Top');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_TOP_DESC', 'Beschreibung Block Repositories Top');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_RANDOM', 'Block zufällige Repositories');
\define('_MI_WGGITHUB_REPOSITORIES_BLOCK_RANDOM_DESC', 'Beschreibung Block zufällige Repositories');
// Config
\define('_MI_WGGITHUB_EDITOR_ADMIN', 'Editor für Admins:');
\define('_MI_WGGITHUB_EDITOR_ADMIN_DESC', 'Wähle Editor, der im Adminbereich verwendet werden soll');
\define('_MI_WGGITHUB_EDITOR_USER', 'Editor User');
\define('_MI_WGGITHUB_EDITOR_USER_DESC', 'Wähle Editor, der im Benutzerbereich verwendet werden soll');
\define('_MI_WGGITHUB_EDITOR_MAXCHAR', 'Maximale Anzahl Zeichen');
\define('_MI_WGGITHUB_EDITOR_MAXCHAR_DESC', 'Maximale Anzahl an Zeichen für die Kurzanzeige von Texten im Adminbereich');
\define('_MI_WGGITHUB_KEYWORDS', 'Keywords');
\define('_MI_WGGITHUB_KEYWORDS_DESC', 'Keywords eingeben (getrennt mit einem Komma)');
\define('_MI_WGGITHUB_AUTOAPPROVED', 'Automatische Freigabe');
\define('_MI_WGGITHUB_AUTOAPPROVED_DESC', 'Die Repositories werden automatisch freigegeben und angezeigt. Wenn Sie diese Option deaktivieren müssen Sie jedes Repository manuell freigeben, damit es auf der Benutzerseite angezeigt wird!');
\define('_MI_WGGITHUB_FILTER_TYPE', 'Typ Filter Releases');
\define('_MI_WGGITHUB_FILTER_TYPE_DESC', 'Wenn Sie bei den verschiedenen Verzeichnissen eine Filtermöglichkeit aktivieren, dann können Sie hier entscheiden, welche Art von Filter verwendet werden soll');
\define('_AM_WGGITHUB_FILTER_TYPE_ALL', "Filter 'Alle (auch jene ohne Release)' verwenden");
\define('_AM_WGGITHUB_FILTER_TYPE_RELEASES', "Filter 'Nur Releases (Final und RC)' verwenden");
\define('_MI_WGGITHUB_NUMB_COL', 'Anzahl Spalten');
\define('_MI_WGGITHUB_NUMB_COL_DESC', 'Anzahl der Spalten in der Tabellenansicht');
\define('_MI_WGGITHUB_DIVIDEBY', 'Geteilt durch');
\define('_MI_WGGITHUB_DIVIDEBY_DESC', 'Geteilt durch Spaltenanzahl');
\define('_MI_WGGITHUB_TABLE_TYPE', 'Tabellentype');
\define('_MI_WGGITHUB_TABLE_TYPE_DESC', 'Tabellentype is bootstrap html table.');
\define('_MI_WGGITHUB_PANEL_TYPE', 'Panel Type');
\define('_MI_WGGITHUB_PANEL_TYPE_DESC', 'Panel Type is the bootstrap html div.');
\define('_MI_WGGITHUB_ADVERTISE', 'Code Werbung');
\define('_MI_WGGITHUB_ADVERTISE_DESC', 'Bitte hier den Code für die Werbung eingeben');
\define('_MI_WGGITHUB_MAINTAINEDBY', 'Unterstützt von');
\define('_MI_WGGITHUB_MAINTAINEDBY_DESC', 'Erlaubt den Url zur Supportseite oder Community');
// ---------------- End ----------------
