<?php

declare(strict_types=1);

namespace XoopsModules\Wggithub\Github;

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @since
 * @author       Goffy - XOOPS Development Team
 */

/**
 * Class GitHub
 */
class GitHub extends GitHubClient
{

    public const BASE_URL = 'https://api.github.com/';
    /**
     * @var string
     */
    public $user = 'myusername';
    /**
     * @var string
     */
    public $token = 'mytoken';
    /**
     * Verbose debugging for curl (when putting)
     * @var bool
     */
    public $debug = false;

    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->getSetting();
    }

    /**
     * @static function &getInstance
     *
     * @param null
     * @return GitHub of GitHub
     */
    public static function getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Get data of all repositories of given user
     *
     * @param string $user
     * @return array

    public function readUserRepositories($user)
    {
        $githubLib = new Repositories();
        $repos = $githubLib->getUserRepositories($user);

        return $repos;
    }
    */

    /**
     * Get data of all repositories of given organisation
     *
     * @param $org
     * @return array

    public function readOrgRepositories($org)
    {
        $githubLib = new Repositories();
        $repos = $githubLib->getOrgRepositories($org);

        return $repos;
    }
    */

    /**
     * Get primary setting
     *
     * @param bool $user
     * @return bool|array
     */
    private function getSetting($user = false)
    {
        $helper = Helper::getInstance();
        $settingsHandler = $helper->getHandler('Settings');
        if ($user) {
            $setting = $settingsHandler->getRequestSetting();
        } else {
            $setting = $settingsHandler->getPrimarySetting();
        }

        if (0 == \count($setting)) {
            \redirect_header('settings.php', 3, \_AM_WGTRANSIFEX_THEREARENT_SETTINGS);
        }

        return $setting;
    }


}
