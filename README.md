# API на Symfony

## Встановлення

### 1. Клонування репозиторію
```sh
git clone https://github.com/AnnaSvin/API_Project.git
```

### 2. Встановлення залежностей
```sh
composer install
```

### 3. Генерація JWT-ключів
```sh
php bin/console lexik:jwt:generate-keypair
```

### 4. Запуск сервера
```sh
php -S localhost:8000 -t public
```
API буде доступне за адресою:
```
http://localhost:8000/api/v1/
```

## Використання API

### 1. Авторизація
- **Логін**: `POST /api/login_check`
- Використовуйте отриманий JWT-токен для доступу до захищених ендпоінтів, передаючи його в заголовку `Authorization: Bearer <token>`

### 2. CRUD-операції
- `GET /api/v1/users` – Отримати список користувачів
- `GET /api/v1/users/{id}` – Отримати конкретного користувача
- `POST /api/v1/users` – Створити нового користувача (тільки для ROLE_ADMIN)
- `PATCH /api/v1/users/{id}` – Оновити користувача
- `DELETE /api/v1/users/{id}` – Видалити користувача (тільки для ROLE_ADMIN)

## Документація API
Документація API доступна за посиланням:
[Postman Documentation](https://documenter.getpostman.com/view/41693248/2sAYX3q3QU)