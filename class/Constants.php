<?php

namespace XoopsModules\Wggithub;

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
 * @author         TDM XOOPS - Email:<goffy@wedega.com> - Website:<https://wedega.com>
 */

/**
 * Interface  Constants
 */
interface Constants
{
	// Constants for tables
    public const TABLE_SETTINGS = 0;
    public const TABLE_REPOSITORIES = 1;
    public const TABLE_DIRECTORIES = 2;
    public const TABLE_REQUESTS = 3;
    public const TABLE_READMES = 4;

    // Constants for tables
    public const DIRECTORY_TYPE_USER = 1;
    public const DIRECTORY_TYPE_ORG  = 2;

	// Constants for status
	public const STATUS_NONE     = 0;
    public const STATUS_NEW      = 1;
    public const STATUS_UPDATED  = 2;
	public const STATUS_UPTODATE = 3;

	// Constants for permissions
	public const PERM_GLOBAL_NONE    = 0;
	public const PERM_GLOBAL_VIEW    = 1;
	public const PERM_GLOBAL_SUBMIT  = 2;
	public const PERM_GLOBAL_APPROVE = 3;

}
