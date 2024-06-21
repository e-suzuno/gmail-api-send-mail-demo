
# Google APIのOAuth2.0を使ってPHPからGmailの送信サービスを利用する


## ディレクトリ構成
   
```
.
├── composer.json
├── composer.lock
├── README.md
└── src
    ├── config        client_credentials.jsonや、アクセストークンを設置するフォルダ
    ├── composer.json
    ├── composer.lock
    ├── oauth2callback.php    :アクセストークンの取得
    ├── send_mail.php         :メール送信プログラム
    └── index.php           　 :トップページ   
    
```




## 準備するもの
 * client_credentials.json
   * OAuth 2.0 クライアント IDを作成
   * OAuthクライアント情報を出力
   * client_credentials.jsonとしてconfigフォルダに保存

 

## シーケンス図 (アクセストークンの発行まで)

```mermaid

sequenceDiagram
    autonumber
    actor Admin
    participant PHP　as PHPプログラム
    participant Google
    Google ->> Admin: OAuthクライアント情報<br>client_credentials.json
    Admin ->> PHP: OAuthクライアント情報をAppに保存
    Admin ->> PHP: アクセス

    PHP ->> PHP: client_credentials.json読み込み
    PHP ->> Google: アクセストークン発行依頼
    Admin ->> Google: ログインと同意
    Google　-->> PHP: 認証コードの送付
    PHP ->>　Google: 認証コードを送信
    Google -->> PHP: アクセストークン、リフレッシュトークンの発行
    PHP ->> PHP: アクセストークン、リフレッシュトークンを保存
```



## シーケンス図  (メール送信等)

```mermaid

sequenceDiagram
    autonumber
    actor user as Uer
    participant PHP　as PHPプログラム
    participant Google

    user ->> PHP: アクセス
    PHP  ->> PHP: client_credentials.json読み込み
    PHP  ->> PHP: トークンの読み込み
    PHP ->> Google: トークンでGmail APIを呼び出し
    

```

