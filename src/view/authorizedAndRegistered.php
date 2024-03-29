<style>
    <?php include './nginx/html/styles.css'; ?>
</style>
<?php
require_once './src/services/JWTService.php'; // Подключаем файл с классом JWTService

class AuthorizedAndRegistered {
    public function showRegistrationSuccess($user_id, $email, $password_check_status, $access_token): void
    {
        echo "<div class='registration-success'>";
        echo "<h2>Регистрация прошла успешно!</h2>";
        echo "<p>Ваш ID: <strong>$user_id</strong></p>";
        echo "<p>Ваш e-mail: <strong>$email</strong></p>";
        echo "<p>Статус надежности Вашего пароля: <strong>$password_check_status</strong></p>";
        echo "<button class='ant-btn ant-btn-primary' onclick=\"window.location.href='/simplified_service_with_registration_and_authorization/nginx/html/index.html'\">Разлогиниться</button>";
        echo "<button class='ant-btn ant-btn-primary' onclick=\"window.location.href='/simplified_service_with_registration_and_authorization/feed.php?token=$access_token'\">Перейти на страницу /feed</button>";
        // Возвращаем результат в формате JSON в соответствии с REST-методологией
        $response = array(
            "access_token" => $access_token
        );
        $json_response = json_encode($response);
        echo "<p>Ответ в JSON-формате: $json_response</p>";

        // Для демонстрации формирования jwt access token'а:
        echo "<h2>Сформированный jwt access token (живёт 15 сек):</h2>";
        echo "<p>Ваш access_token после Регистрации: <strong>$access_token</strong></p>";
        // Для демонстрации наличия user_id в jwt access token'e:
        $decoded_JWT_access_token = JWTService::decodeToken($access_token); // Вызываем метод через класс

        $decoded_response = array(
            "decoded_JWT_access_token" => $decoded_JWT_access_token
        );
        $decoded_json_response = json_encode($decoded_response);
        echo "<h2>Для демонстрации наличия user_id в jwt access token'e ($access_token) — декодированный jwt access token:</h2>";
        echo "<p>$decoded_json_response</p>";
        echo "<p>Обратите внимание, что user_id возвращается целочисленным!</p>";
        echo "</div>";
    }

    public function showAuthorizationSuccess($user_id, $email, $password_check_status, $access_token): void
    {
        echo "<div class='authorization-success'>";
        // Возвращаем HTML-форму с сообщением об успешной регистрации и данными о надежности пароля
        echo "<h2>Авторизация пройдена!</h2>";
        echo "<p>Ваш ID: <strong>$user_id</strong></p>";
        echo "<p>Ваш e-mail: <strong>$email</strong></p>";
        echo "<p>Статус надежности Вашего пароля: <strong>$password_check_status</strong></p>";
        echo "<button class='ant-btn ant-btn-primary' onclick=\"window.location.href='/simplified_service_with_registration_and_authorization/nginx/html/index.html'\">Разлогиниться</button>";
        echo "<button class='ant-btn ant-btn-primary' onclick=\"window.location.href='/simplified_service_with_registration_and_authorization/feed.php?token=$access_token'\">Перейти на страницу /feed</button>";

        // Возвращаем результат в формате JSON в соответствии с REST-методологией
        $response = array(
            "access_token" => $access_token
        );
        $json_response = json_encode($response);
        echo "<p>Ответ в JSON-формате: $json_response</p>";

        // Для демонстрации формирования jwt access token'а:
        echo "<h2>Сформированный jwt access token (живёт 15 сек):</h2>";
        echo "<p>Ваш access_token после Авторизации: <strong>$access_token</strong></p>";
        // Для демонстрации наличия user_id в jwt access token'e:
        $decoded_JWT_access_token = JWTService::decodeToken($access_token); // Вызываем метод через класс

        $decoded_response = array(
            "decoded_JWT_access_token" => $decoded_JWT_access_token
        );
        $decoded_json_response = json_encode($decoded_response);
        echo "<h2>Для демонстрации наличия user_id в jwt access token'e ($access_token) — декодированный jwt access token:</h2>";
        echo "<p>$decoded_json_response</p>";
        echo "<p>Обратите внимание, что user_id возвращается целочисленным!</p>";
        echo "</div>";
    }

    public function showError($message): void
    {
        echo "<div class='error'>";
        echo "<h2>Ошибка</h2>";
        echo "<p>$message</p>";
        echo "</div>";
    }
}
?>