<?php

require 'vendor/autoload.php';

session_start();

?>

<a href="oauth2callback.php">oauth2callback.php</a>
:tokenの作成

<br>

<?php if (file_exists('./config/token.json')) { ?>
    <a href="send_mail.php">send_mail.php</a>:メールの送信
<?php } ?>
