// JWTService.php
<?php
class JWTService {
    public static function generateToken($payload, $expiration_time): string {
        $key = 'our_secret_key123'; // Замените на ваш секретный ключ
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload['exp'] = time() + $expiration_time; // Добавляем время истечения токена
        $payload = json_encode($payload);
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    public static function decodeToken($token) {
        $key = 'our_secret_key123'; // Замените на ваш секретный ключ
        // Разбиваем токен на составляющие
        $tokenParts = explode('.', $token);
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signatureProvided = $tokenParts[2];

        // Подписываем данные с заголовком и телом токена
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        // Проверяем, соответствует ли предоставленная подпись той, которую мы сгенерировали
        if ($base64UrlSignature === $signatureProvided) {
            // Расшифровываем payload
            return json_decode($payload, true);
        }
        return false; // Токен недействителен или его время истекло
    }

    public static function verifyToken($token) {
        $key = 'our_secret_key123'; // Замените на ваш секретный ключ

        // Разбиваем токен на составляющие
        $tokenParts = explode('.', $token);
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signatureProvided = $tokenParts[2];

        // Подписываем данные с заголовком и телом токена
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        // Проверяем, соответствует ли предоставленная подпись той, которую мы сгенерировали
        if ($base64UrlSignature === $signatureProvided) {
            // Проверяем, не истек ли срок действия токена
            $payload = json_decode($payload, true);
            if (isset($payload['exp']) && $payload['exp'] >= time()) {
                return $payload; // Токен действителен
            }
        }
        return false; // Токен недействителен или его время истекло
    }
}
?>
