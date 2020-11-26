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
 * Class Releases
 */
class Releases extends GitHubClient
{
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

}
