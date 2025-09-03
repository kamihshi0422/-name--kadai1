# お問い合わせフォーム

## 環境構築

**Docker ビルド**

1. `git clone git@github.com:kamihshi0422/-name--kadai1.git`
2. DockerDesktop アプリを立ち上げる
3. `docker-compose up -d --build`

**Laravel 環境構築**

1. `docker-compose exec php bash`
2. `composer install`
3. 「.env.example」ファイルを コピーして「.env」を作成し、DB の設定を変更

```text
DB_HOST=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

5. アプリケーションキーの作成

```bash
php artisan key:generate
```

6. マイグレーションの実行

```bash
php artisan migrate
```

7. シーディングの実行

```bash
php artisan db:seed
```

## ER 図


## URL

- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/

