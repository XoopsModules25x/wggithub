<?php
/*
require __DIR__ . '/Github/exceptions.php';
require __DIR__ . '/Github/Sanity.php';
require __DIR__ . '/Github/Helpers.php';

require __DIR__ . '/Github/Storages/ICache.php';
require __DIR__ . '/Github/Storages/ISessionStorage.php';
require __DIR__ . '/Github/Http/IClient.php';

require __DIR__ . '/Github/Storages/FileCache.php';
require __DIR__ . '/Github/Storages/SessionStorage.php';

require __DIR__ . '/Github/Http/Message.php';
require __DIR__ . '/Github/Http/Request.php';
require __DIR__ . '/Github/Http/Response.php';
require __DIR__ . '/Github/Http/CachedClient.php';
require __DIR__ . '/Github/Http/AbstractClient.php';
require __DIR__ . '/Github/Http/CurlClient.php';
require __DIR__ . '/Github/Http/StreamClient.php';

require __DIR__ . '/Github/OAuth/Configuration.php';
require __DIR__ . '/Github/OAuth/Token.php';
require __DIR__ . '/Github/OAuth/Login.php';

require __DIR__ . '/Github/Api.php';
require __DIR__ . '/Github/Paginator.php';
*/

use XoopsModules\Wggithub;
use XoopsModules\Wggithub\Github;

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$

/*
$data = [];
$api = new Github\Api;
$response = $api->get('/emojis');
$data = $api->decode($response);
foreach ($data as $emoji) {
    echo '<img src="' . $emoji . '">';
}
*/

$data = [];
$url = '/orgs/XoopsModules25x/repos?per_page=100&page=1';
echo "<br>Test read org repo:" . $url;
$api = new XoopsModules\Wggithub\Github\GithubClient();
$data = $api->testMilo($url);
$count = 0;
foreach ($data as $key => $repo) {
    echo "<br>key:" . $key . ' repo:' . $repo['name'];
    $count++;
    if ($count>5) {break;}
}


$data = [];
$url = '/users/ggoffy/repos?per_page=100&page=1';
echo "<br><br>Test read user repo:" . $url;
$api = new XoopsModules\Wggithub\Github\GithubClient();
$data = $api->testMilo($url);
$count = 0;
foreach ($data as $key => $repo) {
    echo "<br>key:" . $key . ' repo:' . $repo['name'];
    $count++;
    if ($count>5) {break;}
}


$data = [];
$url = '/repos/XoopsModules25x/smallworld/readme';
echo "<br><br>test read readme orgs:" . $url;
$api = new XoopsModules\Wggithub\Github\GithubClient();
$data = $api->testMilo($url);
echo '<br>name:' . $data['name'];
echo '<br>download_url:' . $data['download_url'];


$data = [];
$url = '/repos/ggoffy/wggithub/readme';
echo "<br><br>test read readme user:" . $url;
$api = new XoopsModules\Wggithub\Github\GithubClient();
$data = $api->testMilo($url);
echo '<br>name:' . $data['name'];
echo '<br>download_url:' . $data['download_url'];


echo "<br><br><br>-----------------------------------";
echo "<br>testMilo2";
echo "<br>-----------------------------------";

$data = [];
$url = '/orgs/XoopsModules25x/repos?per_page=100&page=1';
echo "<br>Test read org repo:" . $url;
$api = new XoopsModules\Wggithub\Github\GithubClient();
$data = $api->testMilo2($url);
$count = 0;
foreach ($data as $key => $repo) {
    echo "<br>key:" . $key . ' repo:' . $repo['name'];
    $count++;
    if ($count>5) {break;}
}


$data = [];
$url = '/users/ggoffy/repos?per_page=100&page=1';
echo "<br><br>Test read user repo:" . $url;
$api = new XoopsModules\Wggithub\Github\GithubClient();
$data = $api->testMilo2($url);
$count = 0;
foreach ($data as $key => $repo) {
    echo "<br>key:" . $key . ' repo:' . $repo['name'];
    $count++;
    if ($count>5) {break;}
}


$data = [];
$url = '/repos/XoopsModules25x/smallworld/readme';
echo "<br><br>test read readme orgs:" . $url;
$api = new XoopsModules\Wggithub\Github\GithubClient();
$data = $api->testMilo2($url);
echo '<br>name:' . $data['name'];
echo '<br>download_url:' . $data['download_url'];


$data = [];
$url = '/repos/ggoffy/wggithub/readme';
echo "<br><br>test read readme user:" . $url;
$api = new XoopsModules\Wggithub\Github\GithubClient();
$data = $api->testMilo2($url);
echo '<br>name:' . $data['name'];
echo '<br>download_url:' . $data['download_url'];


