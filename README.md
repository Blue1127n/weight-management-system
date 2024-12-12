# Pigly (体重管理システム)  
  
## 環境構築  
  
**Dockerビルド**  
    1.GitHub からクローン  
       `git clone git@github.com:coachtech-material/laravel-docker-template.git`    
    2.リポジトリ名の変更  
       `mv laravel-docker-template <任意のリポジトリ名>`   
    3.DockerDesktopアプリを立ち上げる  
       `docker-compose up -d --build`  
       **Laravel環境構築**  
    1.PHPコンテナ内にログイン  
       `docker-compose exec php bash`  
    2.インストール  
       `composer install`  
    3.「.env」ファイルを作成  
       `cp .env.example .env`  
    4..envに以下の環境変数に変更  
      `DB_CONNECTION=mysql`  
      `DB_HOST=mysql`  
      `DB_PORT=3306`  
      `DB_DATABASE=laravel_db`    
      `DB_USERNAME=laravel_user`    
      `DB_PASSWORD=laravel_pass`      
    5.アプリケーションキーの作成  
      `php artisan key:generate`  
    6.マイグレーションの実行  
      `php artisan migrate`  
      
## 使用画像保存先  

  
## 使用技術(実行環境)  
- PHP8.3.11  
- Laravel8.83.8  
- MySQL8.0.26  
  
## ER図  

  
## URL  
- 開発環境：http://localhost/  
- phpMyAdmin:：http://localhost:8080/  
