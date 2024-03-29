# simplified_service_with_registration_and_authorization
Упрощенный сервис с регистрацией и авторизацией

## Запуск:
### PHP Storm:
index.html

### Docker:
Из директории проекта:
docker-compose up

## Структура проекта
```
simplified_service_with_registration_and_authorization/
│
├── nginx/
│   ├── html/
│   │   ├── styles.css
│   │   └── index.html
│   └── nginx.conf
│
├── src/
│   ├── controllers/
│   │   └── UserController.php
│   │
│   ├── models/
│   │   └── User.php
│   │
│   ├── services/
│   │   ├── DBConnection.php
│   │   ├── JWTService.php
│   │   ├── UserRepository.php
│   │   └── UserService.php
│   │
│   └── view/
│       └── authorizedAndRegistered.php
│
├── vendor/
│   └── ЗАВИСИМОСТИ
├── README.md
│  
├── authorize.php
├── register.php
├── feed.php
├── index.html
├── nginx.conf
└── docker-compose.yml
```