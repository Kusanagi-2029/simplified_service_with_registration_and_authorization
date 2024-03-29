//feed.php

<style>
    <?php include './nginx/html/styles.css'; ?>
</style>

<?php
require_once './src/services/JWTService.php';

if (isset($_GET['token'])) {
    $token = $_GET['token']; // Получаем токен из параметра URL

    // Создаем экземпляр JWTService с секретным ключом

    // Проверяем валидность токена с помощью метода verifyToken
    $payload = JWTService::verifyToken($token);

    if ($payload) {
        // Токен валиден
        echo "Token: $token<br>";
        echo "Status code: 200 OK";
    } else {
        // Токен недействителен
        http_response_code(401); // Ошибка авторизации
        echo "Status code: 401 Unauthorized - Токен ПРОСРОЧИЛСЯ";
    }
} else {
    // Если токен не передан
    http_response_code(401); // Ошибка авторизации // Я бы здесь сделал 400 - ошибка Запроса, но по заданию логичнее так оставить
    echo "Status code: 401 Unauthorized - Токен не был передан";
}
?>
