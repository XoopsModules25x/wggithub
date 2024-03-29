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
 * Class Repositories
 */
class Repositories extends GitHub
{

    /**
     * Get repositories of given user
     *
     * @param $username
     * @return bool|array
     */
    public function getUserRepositories($username)
    {
        $url = static::BASE_URL . 'users/' . $username . '/repos';

        return $this->_get($url);
    }

    /**
     * Get repositories of given organisation
     *
     * @param $org
     * @return bool|array
     */
    public function getOrgRepositories($org)
    {
        $url = static::BASE_URL . 'orgs/' . $org . '/repos';
        //$ret = $this->extractData($this->_get($url));
        //return $ret;
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
     * @return bool|array the readme content
     */
    public function getReadme($username, $repository)
    {
        $url = static::BASE_URL . 'repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/readme';
        return $this->_get($url, false, false);
    }


    /*
    private function extractData($arrData) {
        $ret = [];
        foreach ($arrData as $key => $value) {
            $ret[$key]['id'] = $value['id'];
            $ret[$key]['node_id'] = $value['node_id'];
            $ret[$key]['name'] = $value['name'];
            $ret[$key]['full_name'] = $value['full_name'];
        }

        return $ret;
    }
    */

}
