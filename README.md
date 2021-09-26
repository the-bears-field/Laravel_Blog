# Laravel_blog

Laravelを使用して作成しているブログです。  
1つのブログを複数ユーザーが投稿、管理を行うことを想定しています。

## 使用技術
- PHP 8.0.7(cli)
- Laravel v8.42.0
- MYSQL Ver 14.14 Distrib 5.7.31, for Linux(x86_64)

## 必要要件

- Docker
- Docker Compose

## インストール
必要要件に記載している環境を整えた上で、ターミナルで下記コマンドを実行して下さい。

```
git clone https://github.com/the-bears-field/Laravel_blog.git
```
```
cd Laravel_blog
```
```
docker-compose build --no-cache
```
```
docker-compose run --rm app sh initializeAppContainer.sh
```
```
docker-compose up -d
```
CLIENT_URLは、http://localhost:8080です。
