<?php

require 'vendor/autoload.php';


const TOKEN_FILE_PATH = './config/token.json';


$client = new Google_Client();

$client->setAuthConfig('./config/client_credentials.json'); // JSONファイルのパスを指定
$client->addScope(Google_Service_Gmail::GMAIL_SEND);
$client->setAccessType('offline');
$client->setApprovalPrompt('force');


// トークンをファイルから読み込む
if (file_exists(TOKEN_FILE_PATH)) {
    $accessToken = json_decode(file_get_contents(TOKEN_FILE_PATH), true);

    $client->setAccessToken($accessToken);

    // トークンが期限切れの場合、リフレッシュトークンを使用して新しいアクセストークンを取得
    if ($client->isAccessTokenExpired()) {

        $refresh_token = $client->getRefreshToken();
        $client->fetchAccessTokenWithRefreshToken($refresh_token );
        $newAccessToken = $client->getAccessToken();
        $newAccessToken['refresh_token'] = $refresh_token;
        file_put_contents(TOKEN_FILE_PATH, json_encode($newAccessToken));
    }


    $service = new Google_Service_Gmail($client);

    $message = new Google_Service_Gmail_Message();

    $rawMessageString = "From: sender@example.com\r\n";
    $rawMessageString .= "To: recipient@example.com\r\n";
    $rawMessageString .= "Subject: Test Email\r\n";
    $rawMessageString .= "\r\n";
    $rawMessageString .= "This is a test email.";


    $rawMessage = base64_encode($rawMessageString);
    $rawMessage = strtr($rawMessage, array('+' => '-', '/' => '_'));
    $message->setRaw($rawMessage);

    try {
        $service->users_messages->send('me', $message);
        echo "Email sent successfully.";
    } catch (Exception $e) {
        echo 'Message: ' . $e->getMessage();
    }
} else {
    echo 'Token file not found. Please authenticate first.';
}
