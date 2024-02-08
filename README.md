# EC2サーバー
## URL
### Laravel
```
 http://54.64.210.239:81
```

### HONDANA
```
 http://13.231.195.52/admin
```

# ローカル環境
## コマンド
```
docker-compose up -d
```
テストデータを追加したい場合下記コマンドを実行してください
```
docker-compose exec laravel php artisan DB:seed
```
## URL
### laravel
```
http://localhost
```

### HONDANA
```
http://localhost:81/admin/login
```

# テスト
```
docker-compose exec laravel php artisan test
```
※テストの都合上データベースが初期化されるので気を付けてください。  
# デプロイ
Laravelプロジェクトが編集されたときにGithubActionsによって自動で更新されます。  


=======
# トラブルシューティング
## `localhost`をクリックしてエラーが出る場合
下記コマンドを入力する
```
docker compose exec laravel chown www-data storage/ -R
```
上記のコマンドの次に下記コマンドを入力する
```
docker compose exec laravel ls -lh storage
```
# 山本茉美子
## 未経験
### GitHub
初めて
### PHP
初めて
## 興味のある分野・言語など
- SQL
- JAVA
- PHP
### 連絡先
000-0000-0000