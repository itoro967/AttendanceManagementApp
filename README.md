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

users||--o{works:""
works||--o{breaks:""

users{
  unsigned_bigint id PK
  string name
  string email UK
  string email_verified_at
  string password
  bool is_admin
  timestamp created_at
  timestamp updated_at
}
works{
  unsigned_bigint id PK
  unsigned_bigint user_id FK
  date date
  time begin_at
  time finish_at
  unsigned_TinyInteger type
  string note
  bool is_confirmed
  timestamp created_at
  timestamp updated_at
}
breaks{
  unsigned_bigint id PK
  unsigned_bigint work_id FK
  time begin_at
  time finish_at
  timestamp created_at
  timestamp updated_at
}
```
## URL
- 開発環境 : http://localhost/
- MailHog : http://localhost:8025/