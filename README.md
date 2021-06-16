# docker laravel handson

## 参考サイト
https://qiita.com/ucan-lab/items/56c9dc3cf2e6762672f4

## 共通事項

ホストのユーザID、グループIDを環境変数に設定する。
(ホストとコンテナでユーザIDとグループIDが揃ってないとPermission周りで苦労する)

```
export UID=$(id -u)
export GID=$(id -g)
```

## DBの切り替え

DBのデータ保存先は環境変数で指定可能、指定しない場合はデフォルトで`./db/dev`が使われる。

```
# `./db/prod`にデータを保存する場合
export DB_ENV=(prod)
```

## 環境変数表示
```
echo $UID
echo $GID
echo $DB_ENV
```

## 初回

gitからcloneしてきた直後は以下のコマンドで環境を作成する。

```
# Dockerホスト環境
# コンテナ作成
docker compose up -d --build

# Laravelのインストールのために[app]コンテナに入る
docker compose exec app bash

# [app]環境
# Laravelのインストール
composer install

# .envをexampleから用意
cp .env.example .env

# .envにAPP_KEYがないので、以下のコマンドで生成
php artisan key:generate

# public/storage → storage/app/publicへシンボリックリンクを貼る
php artisan storage:link

# storage, bootstrap/cacheに書き込み権限を与える
chmod -R 777 storage bootstrap/cache

# migration
php artisan migrate
```

## 初回以降

```
docker compose up -d
```

## MySQLコンテナ内でMySQLを操作

```
# dbコンテナに入る
docker compose exec db bash

# mysqlコマンド後は自由に操作(ID,PASSはデフォルトのままなら .envを参照)
mysql -p
```

## データベースのデータ保存先を変えるなら

`docker-compose.yml`ないでvolumeの生成とマウントを記述してるのでここを変えればよい。

# トラブルシューティング

## Windows 開発の注意

Windowsとコンテナ間のファイル共有はかなり重いのでDockerホスト側にファイルを置く事を推奨
VS Codeの拡張で RemoteWSLを使うことで、VS Code経由でDockerホスト側のファイルの編集が可能。
こちらの方が断然速い。

起動方法
①VS Codeを起動 → F1 → Ubuntuなど実行したい環境を検索
②Ubuntu側でVSCodeを開く`code .`など

https://qiita.com/_masa_u/items/d3c1fa7898b0783bc3ed


## appコンテナでファイルを作成するとホストから操作できない

Dockerホストとコンテナでuser_idやgroup_idが揃ってない事が原因のようだ。
`docker-compose.yml`にて、[app]コンテナを起動する際のユーザIDとグループIDを
環境変数を参照するようにした。
また`/etc/group`、`/etc/passwd`をappコンテナにマウントする。
