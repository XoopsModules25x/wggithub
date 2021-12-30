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

use XoopsModules\Wggithub;
use XoopsModules\Wggithub\Common\ {
    Configurator,
    Migrate,
    MigrateHelper
};

/**
 * Prepares system prior to attempting to install module
 * @param \XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_update_wggithub(\XoopsModule $module)
{
    $utility = new Wggithub\Utility();

    $xoopsSuccess = $utility::checkVerXoops($module);
    $phpSuccess   = $utility::checkVerPhp($module);

    return $xoopsSuccess && $phpSuccess;
}

/**
 * @param      $module
 * @param null $prev_version
 *
 * @return bool|null
 */
function xoops_module_update_wggithub($module, $prev_version = null)
{
    require \dirname(__DIR__) . '/preloads/autoloader.php';

    $moduleDirName = $module->dirname();

    //wggithub_check_db($module);

    //check upload directory
    include_once __DIR__ . '/install.php';
    xoops_module_install_wggithub($module);

    // update DB corresponding to sql/mysql.sql
    $configurator = new Configurator();
    $migrate = new Migrate($configurator);

    $fileSql = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/sql/mysql.sql';
    // ToDo: add function setDefinitionFile to .\class\libraries\vendor\xoops\xmf\src\Database\Migrate.php
    // Todo: once we are using setDefinitionFile this part has to be adapted
    //$fileYaml = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/sql/update_' . $moduleDirName . '_migrate.yml';
    //try {
    //$migrate->setDefinitionFile('update_' . $moduleDirName);
    //} catch (\Exception $e) {
    // as long as this is not done default file has to be created
    $moduleVersion = $module->getInfo('version');
    $fileYaml = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . "/sql/{$moduleDirName}_{$moduleVersion}_migrate.yml";
    //}

    // create a schema file based on sql/mysql.sql
    $migratehelper = new MigrateHelper($fileSql, $fileYaml);
    if (!$migratehelper->createSchemaFromSqlfile()) {
        \xoops_error('Error: creation schema file failed!');
        return false;
    }

    // run standard procedure for db migration
    $migrate->synchronizeSchema();

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
/*
function wggithub_check_db($module)
{
    $ret = true;
    //insert here code for database check

    return $ret;
}
*/
