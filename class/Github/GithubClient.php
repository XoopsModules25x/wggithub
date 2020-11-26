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

use XoopsModules\Wggithub\Helper;

/**
 * Class GitHubClient
 */
class GitHubClient extends Github
{
    /**
     * GitHub::_get()
     *
     * @param string $url
     * @param bool   $checkOnly
     * @param bool   $throwError
     * @throws \RuntimeException Exception.
     * @return array/bool
     */
    protected function _get($url, $checkOnly = false, $throwError = true)
    {
        if ($this->apiErrorLimit || $this->apiErrorMisc) {
            return [];
        }
        $error = false;
        $ch = \curl_init();
        //set the url, number of POST vars, POST data
        \curl_setopt($ch, \CURLOPT_URL, $url);
        \curl_setopt($ch, \CURLOPT_HTTPAUTH, 'token ' . $this->tokenAuth);
        \curl_setopt($ch, \CURLOPT_USERPWD, $this->userAuth . ':' . $this->tokenAuth);
        \curl_setopt($ch, \CURLOPT_CUSTOMREQUEST, 'GET');
        \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
        \curl_setopt($ch, \CURLOPT_CONNECTTIMEOUT, 25);
        \curl_setopt($ch, \CURLOPT_TIMEOUT, 25);
        \curl_setopt($ch, \CURLOPT_USERAGENT, $this->userAuth);
        if ($this->debug) {
            \curl_setopt($ch, \CURLOPT_VERBOSE, true);
        }
        \curl_setopt($ch, \CURLOPT_SSL_VERIFYHOST, false);
        \curl_setopt($ch, \CURLOPT_SSL_VERIFYPEER, false);
        \curl_setopt($ch, \CURLOPT_POST, 1);
        $result = \curl_exec($ch);
        $info = \curl_getinfo($ch);
        if (($errMsg = \curl_error($ch)) || !\in_array((int)$info['http_code'], [200, 201], true)) {
            $error = $throwError;
        }
        \curl_close($ch);

        $helper = Helper::getInstance();
        $requestsHandler = $helper->getHandler('Requests');
        $submitter = isset($GLOBALS['xoopsUser']) && \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar('uid') : 0;
        $requestsObj = $requestsHandler->create();
        // Set Vars
        $requestsObj->setVar('req_request', $url);
        $requestsObj->setVar('req_result', 'OK');
        $requestsObj->setVar('req_datecreated', time());
        $requestsObj->setVar('req_submitter', $submitter);
        // Insert Data
        if ($requestsHandler->insert($requestsObj, true)) {
            $reqId = $requestsObj->getNewInsertedIdRequests();
        } else {
            throw new \RuntimeException('"' . \_MA_WGGITHUB_READGH_ERROR_INSERTREQ . '"');
        }
        unset($requestsObj);

        if ($checkOnly) {
            return (false == $error);
        }
        if ($error) {
            // update table requests
            $requestsObj = $requestsHandler->get($reqId);
            $requestsObj->setVar('req_result', $result);
            if (!$requestsHandler->insert($requestsObj, true)) {
                throw new \RuntimeException('"' . \_MA_WGGITHUB_READGH_ERROR_INSERTREQ . '"');
            }
            unset($requestsObj);

            if ($this->debug) {
                echo '<br>Error:' . $result;
            }

            //catch common errors
            switch ((int)$info['http_code']) {
                case 401:
                    $this->apiErrorMisc = true;
                    throw new \RuntimeException('"' . \_MA_WGGITHUB_READGH_ERROR_API_401 . '"');
                    break;
                case 403:
                    if (\strpos($result, 'API rate limit exceeded') > 0) {
                        $GLOBALS['xoopsTpl']->assign('apiexceed', true);
                        $this->apiErrorLimit = true;
                        return false;
                    } else {
                        $this->apiErrorMisc = true;
                        throw new \RuntimeException('"' . \_MA_WGGITHUB_READGH_ERROR_API_403 . '"');
                    }
                    break;
                case 404:
                    $this->apiErrorMisc = true;
                    throw new \RuntimeException('"' . \_MA_WGGITHUB_READGH_ERROR_API_404 . '"');
                    break;
                case 405:
                    $this->apiErrorMisc = true;
                    throw new \RuntimeException('"' . \_MA_WGGITHUB_READGH_ERROR_API_405 . '"');
                    break;
                case 0:
                default:
                    $this->apiErrorMisc = true;
                    throw new \RuntimeException('"' . \_MA_WGGITHUB_READGH_ERROR_API . ': ' . $errMsg . '"');
                    break;
            }
        } else {
            return \json_decode($result, true);
        }
    }
}
