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
 * @author         Goffy - XOOPS Development Team - Email:<goffy@wedega.com> - Website:<https://wedega.com>
 */

use XoopsModules\Wggithub;
use XoopsModules\Wggithub\MDParser;

\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Readmes
 */
class Readmes extends \XoopsObject
{
    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('rm_id', \XOBJ_DTYPE_INT);
        $this->initVar('rm_repoid', \XOBJ_DTYPE_INT);
        $this->initVar('rm_name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('rm_type', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('rm_content', \XOBJ_DTYPE_TXTAREA);
        $this->initVar('rm_encoding', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('rm_downloadurl', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('rm_baseurl', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('rm_datecreated', \XOBJ_DTYPE_INT);
        $this->initVar('rm_submitter', \XOBJ_DTYPE_INT);
    }

    /**
     * @static function &getInstance
     *
     * @param null
     */
    public static function getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
    }

    /**
     * The new inserted $Id
     * @return inserted id
     */
    public function getNewInsertedIdReadmes()
    {
        $newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
        return $newInsertedId;
    }

    /**
     * @public function getForm
     * @param bool $action
     * @param int  $start
     * @param int  $limit
     * @return \XoopsThemeForm
     */
    public function getFormReadmes($action = false, $start = 0, $limit = 0)
    {
        $helper = \XoopsModules\Wggithub\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }

        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm(\_AM_WGGITHUB_README_EDIT, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Table repositories
        $repositoriesHandler = $helper->getHandler('Repositories');
        $rmRepoidSelect = new \XoopsFormSelect(\_AM_WGGITHUB_README_REPOID, 'rm_repoid', $this->getVar('rm_repoid'));
        $rmRepoidSelect->addOptionArray($repositoriesHandler->getList());
        $form->addElement($rmRepoidSelect);
        // Form Text rmName
        $form->addElement(new \XoopsFormText(\_AM_WGGITHUB_README_NAME, 'rm_name', 50, 255, $this->getVar('rm_name')));
        // Form Text rmType
        $form->addElement(new \XoopsFormText(\_AM_WGGITHUB_README_TYPE, 'rm_type', 50, 255, $this->getVar('rm_type')));
        // Form Editor TextArea rmContent
        $form->addElement(new \XoopsFormTextArea(\_AM_WGGITHUB_README_CONTENT, 'rm_content', $this->getVar('rm_content', 'e'), 4, 47));
        // Form Text rmEncoding
        $form->addElement(new \XoopsFormText(\_AM_WGGITHUB_README_ENCODING, 'rm_encoding', 50, 255, $this->getVar('rm_encoding')));
        // Form Text rmDownloadurl
        $form->addElement(new \XoopsFormText(\_AM_WGGITHUB_README_DOWNLOADURL, 'rm_downloadurl', 50, 255, $this->getVar('rm_downloadurl')));
        // Form Text rmBaseurl
        $form->addElement(new \XoopsFormText(\_AM_WGGITHUB_README_BASEURL, 'rm_baseurl', 50, 255, $this->getVar('rm_baseurl')));
        // Form Text Date Select rmDatecreated
        $rmDatecreated = $this->isNew() ?: $this->getVar('rm_datecreated');
        $form->addElement(new \XoopsFormTextDateSelect(\_AM_WGGITHUB_README_DATECREATED, 'rm_datecreated', '', $rmDatecreated));
        // Form Select User rmSubmitter
        $form->addElement(new \XoopsFormSelectUser(\_AM_WGGITHUB_README_SUBMITTER, 'rm_submitter', false, $this->getVar('rm_submitter')));
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'save'));
        $form->addElement(new \XoopsFormHidden('start', $start));
        $form->addElement(new \XoopsFormHidden('limit', $limit));
        $form->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));
        return $form;
    }

    /**
     * Get Values
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
    public function getValuesReadmes($keys = null, $format = null, $maxDepth = null)
    {
        $helper  = \XoopsModules\Wggithub\Helper::getInstance();
        $utility = new \XoopsModules\Wggithub\Utility();
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id']            = $this->getVar('rm_id');
        $repositoriesHandler = $helper->getHandler('Repositories');
        $repositoriesObj = $repositoriesHandler->get($this->getVar('rm_repoid'));
        $repoName = '*****missing repo_name*****';
        if (\is_object($repositoriesObj)) {
            $repoName = $repositoriesObj->getVar('repo_name');
        }
        $ret['repoid']        = $repoName;
        $rmName = $this->getVar('rm_name');
        $ret['name']          = $rmName;
        $ret['type']          = $this->getVar('rm_type');
        $baseUrl              = $this->getVar('rm_baseurl');
        $ret['baseurl']       = $baseUrl;
        $ret['content']       = $this->getVar('rm_content', 'e');
        $contentDecoded = base64_decode($this->getVar('rm_content', 'n'));
        if ('.MD' == \substr(strtoupper($rmName), -3)) {
            $Parsedown = new MDParser\Parsedown();
            $contentEncoded = $Parsedown->text($contentDecoded);
            $baseUrl = \str_replace('/blob/', '/raw/', $baseUrl);
            $contentClean = $this->cleaningMD($contentEncoded, $baseUrl);
        } else {
            $contentClean = $contentDecoded;
        }
        $ret['content_clean'] = $contentClean;
        $editorMaxchar = $helper->getConfig('editor_maxchar');
        $ret['content_short'] = $utility::truncateHtml($ret['content'], $editorMaxchar);
        $ret['encoding']      = $this->getVar('rm_encoding');
        $ret['downloadurl']   = $this->getVar('rm_downloadurl');
        $ret['datecreated']   = \formatTimestamp($this->getVar('rm_datecreated'), 'm');
        $ret['submitter']     = \XoopsUser::getUnameFromId($this->getVar('rm_submitter'));
        $ret['gitbook_link']  = '';
        if (\strpos($ret['downloadurl'], 'XoopsDoc') > 0) {
            $ret['gitbook_link']  = 'https://xoops.gitbook.io/' . $repoName . '/';
        }
        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArrayReadmes()
    {
        $ret = [];
        $vars = $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar('"{$var}"');
        }
        return $ret;
    }
    /**
     * Returns an array representation of the object
     * @param  $textMD
     * @param  $baseUrl
     * @return string
     */
    private function cleaningMD($textMD, $baseUrl)
    {
        $baseUrl = \str_replace('/blob/', '/raw/', $baseUrl);

        $contentClean = \str_replace('http://', 'https://', $textMD);

        //replace image links
        $arrSearch = [
            'src="https://xoops.org/images/logoXoopsPhp8_400.png',
            "src='https://xoops.org/images/logoXoopsPhp8_400.png",
            'src=".gitbook/assets/',
            "src='.gitbook/assets/",
            'src="en/assets/',
            "src='en/assets/",
            'src="assets/',
            "src='assets/"
        ];
        $arrReplace = [
            'src="https://xoops.org/images/logoXoopsPhp8.png',
            "src='https://xoops.org/images/logoXoopsPhp8.png",
            'src="' . $baseUrl . '.gitbook/assets/',
            "src='" . $baseUrl . '.gitbook/assets/',
            'src="' . $baseUrl . 'en/assets/',
            "src='" . $baseUrl . 'en/assets/',
            'src="' . $baseUrl . 'assets/',
            "src='" . $baseUrl . 'assets/'
        ];
        $contentClean = \str_replace($arrSearch, $arrReplace, $contentClean);

        //replace known missing images
        $arrSearch = [
            'src="' . \XOOPS_URL . '/screenshot.jpg',
            'src="' . \XOOPS_URL . '/sd-099-theme-surprice.gif',
            'src="' . \XOOPS_URL . '/shot.gif',
            'src="' . \XOOPS_URL . '/shot.jpg',
            'src="' . \XOOPS_URL . '/theme_preview.png',
            'src="https://github.com/xoops/newbb-tutorial/tree/54ef6104e66b74e8c6dea683d3cce70ceafdd739/assets/image001.jpg',
            'src="https://github.com/xoops/repairshop-tutorial/tree/719d6d32dea221b3e980fd3d6222f179ac898394/en/assets/img_2.jpg',
            'src="https://github.com/xoops/xoops-mylinks-tutorial/tree/d30c30645d48c5ead51399ff711c25935cbd0495/en/assets/forkit.png',
            'src="https://github.com/xoops/xoopspartners-tutorial/tree/f41bf73b884ccd906dc6a8323363b9b1aa3f8d02/en/assets/forkit.png',
            'src="https://github.com/XoopsDocs/adslight-tutorial/raw/master/en/assets/image001.png',
            'src="https://github.com/XoopsDocs/avaman-tutorial/raw/master/en/assets/image001.png',
            'src="https://github.com/XoopsDocs/extgallery-tutorial/raw/master/en/assets/forkit.png',
            'src="https://github.com/XoopsDocs/extgallery-tutorial/raw/master/en/assets/image001.png',
            'src="https://github.com/XoopsDocs/presenter-tutorial/raw/master/en/assets/image001.png',
            'src="https://github.com/XoopsDocs/smartpartner-tutorial/raw/master/en/assets/image001.png',
            'src="https://github.com/XoopsDocs/tag-tutorial/raw/master/en/assets/image001.png',
            'src="https://github.com/XoopsDocs/wfdownloads-tutorial/raw/master/en/assets/forkit.png',
            'src="https://github.com/XoopsDocs/wfdownloads-tutorial/raw/master/en/assets/image001.png',
            'src="https://github.com/XoopsDocs/xasset-tutorial/tree/9b95bc0ae0219c95a8cf16e77b9cd2175d856e89/en/assets/image001.png',
            'src="https://github.com/XoopsDocs/xoops_codex/raw/master/en/assets/image001.png',
            'src="https://img.shields.io/codeclimate/github/mambax7/adslight.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/avaman.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/extcal.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/extgallery.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/gbook.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/marquee.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/mastopgo2.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/moduleinstaller.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/myconference.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/newbb.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/planet.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/publisher.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/randomquote.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/references/.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/smartfaq.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/smartpartner.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/suico.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/tdmpicture.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/waiting.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/wflinks.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/xfaq.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/xoopsheadline.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/mambax7/xoopspoll.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/about.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/adminer.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/contact.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/content.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/cssholmes.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/lexikon.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/myiframe.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/mylinks.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/mymenus.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/news.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/smallworld.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/soapbox.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/tag.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/tdmdownloads.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/userlog.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/xbssacc.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/xbstags.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/xbsvat.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/xfguestbook.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/xlanguage.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/xmfdemo.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/xoopsfaq.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/xoopshp.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/xoopsinfo.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/xoopspartners.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/xoopstube.svg?style=flat',
            'src="https://img.shields.io/codeclimate/github/XoopsModules25x/xsitemap.svg?style=flat',
            'src="https://img.shields.io/github/release/mambax7/references/.svg?style=flat',
            'src="https://img.shields.io/github/tag/mambax7/references/.svg?style=flat',
            'src="https://insight.sensiolabs.com/projects/7ada0220-a68e-4369-aef0-950172630ff8/mini.png',
            'src="https://xoops.org/images/translations-github-blue.svg',
        ];
        $contentClean = \str_replace($arrSearch, 'src="' . \WGGITHUB_IMAGE_URL . '/blank.gif', $contentClean);

        return $contentClean;
    }
}
