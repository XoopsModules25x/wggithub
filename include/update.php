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
 * Wggithub module for xoops
 *
 * @param mixed      $module
 * @param null|mixed $prev_version
 * @package        Wggithub
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         Wedega - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 * @version        $Id: 1.0 update.php 1 Mon 2018-03-19 10:04:53Z XOOPS Project (www.xoops.org) $
 * @copyright      module for xoops
 * @license        GPL 2.0 or later
 */

/**
 * @param      $module
 * @param null $prev_version
 *
 * @return bool|null
 */
function xoops_module_update_wggithub($module, $prev_version = null)
{
    //wggithub_check_db($module);

    //check upload directory
    include_once __DIR__ . '/install.php';
    xoops_module_install_wggithub($module);

    $errors = $module->getErrors();
    if (!empty($errors)) {
        print_r($errors);
    }

    return true;

}

/**
 * @param $module
 *
 * @return bool
 */
function wggithub_check_db($module)
{
    $ret = true;
    //insert here code for database check

    // update table (add new field)
    $table   = $GLOBALS['xoopsDB']->prefix('wggithub_repositories');
    $field   = 'repo_release';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` INT(1) NOT NULL DEFAULT '0' AFTER `repo_htmlurl`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    // update table (add new field)
    $table   = $GLOBALS['xoopsDB']->prefix('wggithub_repositories');
    $field   = 'repo_prerelease';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` INT(1) NOT NULL DEFAULT '0' AFTER `repo_htmlurl`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }
    // update table (add new field)
    $table   = $GLOBALS['xoopsDB']->prefix('wggithub_repositories');
    $field   = 'repo_readme';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` INT(1) NOT NULL DEFAULT '0' AFTER `repo_htmlurl`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    // update table (add new field)
    $table   = $GLOBALS['xoopsDB']->prefix('wggithub_directories');
    $field   = 'dir_filterrelease';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` INT(1) NOT NULL DEFAULT '0' AFTER `dir_online`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    // create new table
    $table   = $GLOBALS['xoopsDB']->prefix('wggithub_logs');
    $check   = $GLOBALS['xoopsDB']->queryF("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='$table'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        // create new table
        $sql = "CREATE TABLE `$table` (
              `log_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
              `log_type` INT(1) NOT NULL DEFAULT '0',
              `log_details` VARCHAR(255) NOT NULL DEFAULT '',
              `log_result` TEXT NOT NULL ,
              `log_datecreated` INT(11) NOT NULL DEFAULT '0',
              `log_submitter` INT(10) NOT NULL DEFAULT '0',
              PRIMARY KEY (`log_id`)
                ) ENGINE=InnoDB;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when creating table '$table'.");
            $ret = false;
        }
    }

    // update table (add new field)
    $table   = $GLOBALS['xoopsDB']->prefix('wggithub_directories');
    $field   = 'dir_content';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` INT(10) NOT NULL DEFAULT '0' AFTER `dir_type`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    // update table (add new field)
    $table   = $GLOBALS['xoopsDB']->prefix('wggithub_directories');
    $field   = 'dir_descr';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` TEXT NOT NULL AFTER `dir_type`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    // update table (add new field)
    $table   = $GLOBALS['xoopsDB']->prefix('wggithub_readmes');
    $field   = 'rm_baseurl';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` VARCHAR(255) NOT NULL DEFAULT '' AFTER `rm_downloadurl`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    // update table (add new field)
    $table   = $GLOBALS['xoopsDB']->prefix('wggithub_directories');
    $field   = 'dir_weight';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` INT(10) NOT NULL DEFAULT '0' AFTER `dir_filterrelease`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    // update table (add new field)
    $table   = $GLOBALS['xoopsDB']->prefix('wggithub_repositories');
    $field   = 'repo_approved';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` INT(1) NOT NULL DEFAULT '0' AFTER `repo_release`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    return $ret;
}
