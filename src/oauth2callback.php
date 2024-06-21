<?php

require 'vendor/autoload.php';

session_start();

const TOKEN_FILE_PATH = './config/token.json';


$client = new Google_Client();
$client->setAuthConfig('./config/client_credentials.json'); // JSONファイルのパスを指定

$client->addScope(Google_Service_Gmail::GMAIL_SEND);
$client->setRedirectUri('http://localhost/oauth2callback.php'); // リダイレクトURIを指定
$client->setAccessType('offline');
$client->setApprovalPrompt('force');


if (!isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    exit();
} else {

    $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $access_token = $client->getAccessToken();
    // アクセストークンとリフレッシュトークンをファイルに保存
    file_put_contents(TOKEN_FILE_PATH, json_encode($access_token));

    header('Location: ' . filter_var('index.php', FILTER_SANITIZE_URL));
    exit();
}
