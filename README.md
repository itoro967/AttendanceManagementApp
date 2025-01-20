# AttendanceManagementApp

## 環境構築
### Dockerビルド
- git clone https://github.com/itoro967/AttendanceManagementApp.git
- cd AttendanceManagementApp
- sudo docker-compose up -d --build
### Laravel環境構築
### 仕様技術
- Laravel 10.48.25
- MailHog ※最新版を使用
- nginx 1.27.2
- MySQL 9.0.1
- PHP 8.2-fpm
## ER図
```mermaid
erDiagram

## URL
- 開発環境 : http://localhost/
- MailHog : http://localhost:8025/