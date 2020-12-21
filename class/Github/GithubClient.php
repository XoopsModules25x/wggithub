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

use XoopsModules\Wggithub;
use XoopsModules\Wggithub\{
    Helper,
    Constants,
    Github
};

/**
 * Class GithubClient
 */
class GithubClient extends Api
{
    /**
     * @var string
     */
    public const BASE_URL = 'https://api.github.com/';

    /**
     * @var string
     */
    public $userAuth = 'myusername';

    /**
     * @var string
     */
    public $tokenAuth = 'mytoken';

    /**
     * @var string
     */
    public $requestType = 'curl';

    /**
     * Verbose debugging for curl (when putting)
     * @var bool
     */
    public $debug = false;

    /**
     * @var object
     */
    private $helper = null;

    /**
     * @var bool
     */
    public $apiErrorLimit = false;

    /**
     * @var bool
     */
    public $apiErrorMisc = false;

    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->helper = \XoopsModules\Wggithub\Helper::getInstance();
        $this->getSetting();
    }

    /**
     * @static function &getInstance
     *
     * @param null
     * @return GitHubClient of Api
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
     * Get repositories of given user
     *
     * @param     $username
     * @param int $per_page
     * @param int $page
     * @return array
     */
    public function getUserRepositories($username, $per_page = 100, $page = 1)
    {
        $url = static::BASE_URL . 'users/' . \rawurlencode($username) . '/repos?per_page=' . $per_page . '&page=' . $page;

        return $this->_get($url);
    }

    /**
     * Get repositories of given organisation
     *
     * @param     $org
     * @param int $per_page
     * @param int $page
     * @return array
     */
    public function getOrgRepositories($org, $per_page = 100, $page = 1)
    {
        $url = static::BASE_URL . 'orgs/' . \rawurlencode($org) . '/repos?per_page=' . $per_page . '&page=' . $page;

        return $this->_get($url);
    }

    /**
     * Get the readme content for a repository by its username and repository name.
     *
     * @link http://developer.github.com/v3/repos/contents/#get-the-readme
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     *
     * @return string|array the readme content
     */
    public function getReadme($username, $repository)
    {
        $url = static::BASE_URL . 'repos/' . \rawurlencode($username) . '/' . \rawurlencode($repository) . '/readme';

        return $this->_get($url);
    }

    /**
     * Get all releases
     *
     * @param $user
     * @param $repository
     * @return array
     */
    public function getReleases($user, $repository)
    {
        $url = static::BASE_URL . 'repos/' . $user . '/' . $repository . '/releases';

        return $this->_get($url);
    }

    /**
     * Get latest release
     *
     * @param $user
     * @param $repository
     * @param bool $prerelease
     * @return array
     */
    public function getLatestRelease($user, $repository, $prerelease = false)
    {
        if ($prerelease) {
            $url = static::BASE_URL . 'repos/' . $user . '/' . $repository . '/releases';
        } else {
            $url = static::BASE_URL . 'repos/' . $user . '/' . $repository . '/releases/latest';
        }
        $result = $this->_get($url);

        if ($prerelease) {
            if (\is_array($result)) {
                return $result[0];
            } else {
                return [];
            }
        }

        return $result;
    }

    public function _get($url)
    {
        $logsHandler = $this->helper->getHandler('Logs');
        $logsHandler->updateTableLogs(Constants::LOG_TYPE_REQUEST, $url, '');

        $api = new Github\Api;
        $token = new Github\OAuth\Token($this->tokenAuth, 'bearer', ['repo']);
        $api->setToken($token);
        $request = $api->createRequest('GET', $url, [], [], '');
        $response = $api->request($request);
        $data = (array)$api->decode($response);

        return $data;
    }

    /**
     * Get primary setting
     *
     * @param bool $user
     * @return bool|array
     */
    private function getSetting($user = false)
    {
        $settingsHandler = $this->helper->getHandler('Settings');
        $setting = $settingsHandler->getPrimarySetting();

        if (0 == \count($setting)) {
            \redirect_header(\XOOPS_URL . '/index.php', 3, \_AM_WGGITHUB_THEREARENT_SETTINGS);
        }
        $this->userAuth = $setting['user'];
        $this->tokenAuth = $setting['token'];

        return true;
    }
}
