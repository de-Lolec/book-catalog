#### Запуск окружения и проекта.

Запуск backend:

```bash
cd /backend

composer install

cp env.example .env

./vendor/bin/sail up -d

./vendor/bin/sail artisan migrate

./vendor/bin/sail artisan db:seed
```

Запуск frontend:

```bash
cd /frontend

npm install

cp env.example .env

npm run dev
```

Логин и пароль от аккаунта админа <br>
Логин: admin@admin.admin  <br>
Пароль: password

