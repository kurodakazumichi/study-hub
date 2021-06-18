# docker laravel handson

## 参考サイト
https://qiita.com/ucan-lab/items/56c9dc3cf2e6762672f4

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

Dockerホストとコンテナでuser_idやgroup_idが揃ってないといろんなところで問題が起こる。

あれこれしたが、コンテナはだいたいrootユーザで動く事を前提にしていたり
もしくはなんらか特定のユーザで動作する想定で作られていたりするので
コンテナ内のユーザを変えたりなんだったりするとこれまたおかしなことが起こる。

最終的にWSL側のUbuntuをrootユーザにしてしまうことで今のところ落ち着いている。

## DBのバックアップ

```
# フォーマット
docker exec -it `コンテナ名` mysqldump --single-transaction -u`DBユーザ` -p`DBパスワード` `DB名` > `出力先のパス`

# サンプル
docker exec -it study-hub_db_1 mysqldump --single-transaction -uphper -psecret laravel > ./dump.sql
mv ./dump.sql /mnt/d/backup/study-hub/db_`date "+%Y%m%d_%H%M%S"`.dump
```