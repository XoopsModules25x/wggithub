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

use Xmf\Request;
use XoopsModules\Wggithub;
use XoopsModules\Wggithub\{
    Constants,
    Helper,
    Github\GithubClient
};

require __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wggithub_index.tpl';
include_once \XOOPS_ROOT_PATH . '/header.php';
// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
$keywords = [];
// 
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wggithub_url', \WGGITHUB_URL);
//

$libRepositories = new GithubClient();
$libReleases = new GithubClient();

$releases = $libReleases->getReleases('XoopsModules25x', 'modulebuilder');
var_dump($releases);

/*
$content = 'IVthbHQgWE9PUFMgQ01TXShodHRwczovL3hvb3BzLm9yZy9pbWFnZXMvbG9n
b1hvb3BzNEdpdGh1YlJlcG9zaXRvcnkucG5nKQojIyBDb250YWN0IG1vZHVs
ZSBmb3IgW1hPT1BTIENNUyAyLjUuOCtdKGh0dHBzOi8veG9vcHMub3JnKQpb
IVtYT09QUyBDTVMgTW9kdWxlXShodHRwczovL2ltZy5zaGllbGRzLmlvL2Jh
ZGdlL1hPT1BTJTIwQ01TLU1vZHVsZS1ibHVlLnN2ZyldKGh0dHBzOi8veG9v
cHMub3JnKQpbIVtTb2Z0d2FyZSBMaWNlbnNlXShodHRwczovL2ltZy5zaGll
bGRzLmlvL2JhZGdlL2xpY2Vuc2UtR1BMLWJyaWdodGdyZWVuLnN2Zz9zdHls
ZT1mbGF0KV0oTElDRU5TRSkKClshW1NjcnV0aW5pemVyIENvZGUgUXVhbGl0
eV0oaHR0cHM6Ly9pbWcuc2hpZWxkcy5pby9zY3J1dGluaXplci9nL21hbWJh
eDcvY29udGFjdC5zdmc/c3R5bGU9ZmxhdCldKGh0dHBzOi8vc2NydXRpbml6
ZXItY2kuY29tL2cvbWFtYmF4Ny9jb250YWN0Lz9icmFuY2g9bWFzdGVyKQpb
IVtDb2RhY3kgQmFkZ2VdKGh0dHBzOi8vYXBpLmNvZGFjeS5jb20vcHJvamVj
dC9iYWRnZS9ncmFkZS81ODY5NmZiNTNlMTc0OGQwOTZiNDU3ZGU3YzkzOWQw
ZildKGh0dHBzOi8vd3d3LmNvZGFjeS5jb20vYXBwL21hbWJheDcvY29udGFj
dF8yKQpbIVtDb2RlIENsaW1hdGVdKGh0dHBzOi8vaW1nLnNoaWVsZHMuaW8v
Y29kZWNsaW1hdGUvZ2l0aHViL1hvb3BzTW9kdWxlczI1eC9jb250YWN0LnN2
Zz9zdHlsZT1mbGF0KV0oaHR0cHM6Ly9jb2RlY2xpbWF0ZS5jb20vZ2l0aHVi
L1hvb3BzTW9kdWxlczI1eC9jb250YWN0KQpbIVtTZW5zaW9MYWJzSW5zaWdo
dF0oaHR0cHM6Ly9pbnNpZ2h0LnNlbnNpb2xhYnMuY29tL3Byb2plY3RzLzZh
NDdjN2YzLTBjZWItNGYyMS1iYjhjLTc1YTNmN2NkMTY1OC9taW5pLnBuZyld
KGh0dHBzOi8vaW5zaWdodC5zZW5zaW9sYWJzLmNvbS9wcm9qZWN0cy82YTQ3
YzdmMy0wY2ViLTRmMjEtYmI4Yy03NWEzZjdjZDE2NTgpClshW0xhdGVzdCBQ
cmUtUmVsZWFzZV0oaHR0cHM6Ly9pbWcuc2hpZWxkcy5pby9naXRodWIvdGFn
L1hvb3BzTW9kdWxlczI1eC9jb250YWN0LnN2Zz9zdHlsZT1mbGF0KV0oaHR0
cHM6Ly9naXRodWIuY29tL1hvb3BzTW9kdWxlczI1eC9jb250YWN0L3RhZ3Mv
KQpbIVtMYXRlc3QgVmVyc2lvbl0oaHR0cHM6Ly9pbWcuc2hpZWxkcy5pby9n
aXRodWIvcmVsZWFzZS9Yb29wc01vZHVsZXMyNXgvY29udGFjdC5zdmc/c3R5
bGU9ZmxhdCldKGh0dHBzOi8vZ2l0aHViLmNvbS9Yb29wc01vZHVsZXMyNXgv
Y29udGFjdC9yZWxlYXNlcy8pCgoqKkNvbnRhY3QqKiBtb2R1bGUgZm9yIFtY
T09QUyBDTVNdKGh0dHBzOi8veG9vcHMub3JnKSBpcyBhIHNpbXBsZSBtb2R1
bGUgaGVscGluZyB2aXNpdG9ycyB0byBjb250YWN0IHRoZSBXZWJzaXRlIEFk
bWluaXN0cmF0b3IgCgpbIVtUdXRvcmlhbCBBdmFpbGFibGVdKGh0dHBzOi8v
eG9vcHMub3JnL2ltYWdlcy90dXRvcmlhbC1hdmFpbGFibGUtYmx1ZS5zdmcp
XShodHRwczovL3d3dy5naXRib29rLmNvbS9ib29rL3hvb3BzL3hvb3BzLWNv
bnRhY3QtbW9kdWxlLykgVHV0b3JpYWw6IHNlZSBbR2l0Qm9va10oaHR0cHM6
Ly93d3cuZ2l0Ym9vay5jb20vYm9vay94b29wcy94b29wcy1jb250YWN0LW1v
ZHVsZS8pLiAKVG8gY29udHJpYnV0ZSB0byB0aGUgVHV0b3JpYWwsIFtmb3Jr
IGl0IG9uIEdpdEh1Yl0oaHR0cHM6Ly9naXRodWIuY29tL1hvb3BzRG9jcy9j
b250YWN0LXR1dG9yaWFsKQoKWyFbVHJhbnNsYXRpb25zIG9uIFRyYW5zaWZl
eF0oaHR0cHM6Ly94b29wcy5vcmcvaW1hZ2VzL3RyYW5zbGF0aW9ucy10cmFu
c2lmZXgtYmx1ZS5zdmcpXShodHRwczovL3d3dy50cmFuc2lmZXguY29tL3hv
b3BzKSAKCl9QbGVhc2UgdmlzaXQgdXMgb24gaHR0cHM6Ly94b29wcy5vcmdf
CgpDdXJyZW50IGFuZCB1cGNvbWluZyAibmV4dCBnZW5lcmF0aW9uIiB2ZXJz
aW9ucyBvZiBYT09QUyBDTVMgYXJlIGJlaW5nIGNyYWZ0ZWQgb24gR2l0SHVi
IGF0OiBodHRwczovL2dpdGh1Yi5jb20vWE9PUFMK
';
$contentDecoded = base64_decode($content);

$res = $helper->getHandler('Readmes')->convertMD($contentDecoded);
*/


/*
$github = Github::getInstance();
$github->apiErrorLimit = false;
$github->apiErrorMisc = false;
$crRepositories = new \CriteriaCompo();
$crRepositories->add(new \Criteria('repo_user', 'XoopsThemes'));
$crRepositories->add(new \Criteria('repo_status', '1'));
//$crRepositories->setStart(0);
//$crRepositories->setLimit(48);
$repositoriesCount = $repositoriesHandler->getCount($crRepositories);
$repositoriesAll = $repositoriesHandler->getAll($crRepositories);
if ($repositoriesCount > 0) {
    // Get All Repositories
    foreach (\array_keys($repositoriesAll) as $i) {
        $repoId = $repositoriesAll[$i]->getVar('repo_id');
        $res = $helper->getHandler('Readmes')->updateReadmes($repoId, $repositoriesAll[$i]->getVar('repo_user'), $repositoriesAll[$i]->getVar('repo_name'));
        //$res = $helper->getHandler('Releases')->updateReleases($repoId, $repositoriesAll[$i]->getVar('repo_user'), $repositoriesAll[$i]->getVar('repo_name'));
        if ($res) {
            // change status to updated
            $repositoriesObj = $repositoriesHandler->get($repoId);
            $repositoriesObj->setVar('repo_status', Constants::STATUS_UPTODATE);
            $repositoriesHandler->insert($repositoriesObj, true);
        } else {
            echo "Error:" . $repositoriesAll[$i]->getVar('repo_user') . ' - ' . $repositoriesAll[$i]->getVar('repo_name');
        }
        if ($github->apiErrorLimit) {
            break;
        }
    }
}
*/


//$releases = $libReleases->getReleases('XoopsModules25x', 'modulebuilder');
//var_dump($releases);

//$helper->getHandler('Readmes')->updateTableReadmes();
//$helper->getHandler('Releases')->updateTableReleases();


/*

$github = GitHub::getInstance();







$result = $libRepositories->getUserRepositories('ggoffy');
//$result = $github->readOrgRepositories('XoopsModules25x');
var_dump($result);


$githubLib = new Repositories();
$result = $githubLib->getOrgRepositories('XoopsModules25x');
var_dump($result);

$githubLib = new Releases();
$result = $githubLib->getLatestRelease('XoopsModules25x', 'contact', true);
var_dump($result);


$result = $libRepositories->getReadme('XoopsModules25x', 'wggallery');
var_dump($result);
*/

require __DIR__ . '/footer.php';
