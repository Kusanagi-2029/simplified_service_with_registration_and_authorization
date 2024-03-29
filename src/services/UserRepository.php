//services/UserRepository.php
<?php
require_once 'DBConnection.php'; // Подключаемся к базе данных
require_once 'JWTService.php'; // Подключаем файл с классом JWTService

class UserRepository {
    private \PgSql\Connection|false $db_connection;

    public function __construct() {
        // Создаем экземпляр класса DBConnection и получаем соединение с базой данных
        $dbConnection = DBConnection::getInstance();
        $this->db_connection = $dbConnection->getConnection();
    }

    public function registerUser($user): array
    {
        $email = $user->getEmail();
        $password = $user->getPassword();
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Проверка валидности email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return array(
                'success' => false,
                'message' => 'Неверный формат email'
            );
        }

        // Проверка наличия пользователя с таким email в базе данных
        $query = "SELECT COUNT(*) AS count FROM users WHERE email = $1";
        $result = pg_query_params($this->db_connection, $query, array($email));
        $row = pg_fetch_assoc($result);

        if ($row['count'] > 0) {
            return array(
                'success' => false,
                'message' => 'Пользователь с таким email уже зарегистрирован'
            );
        }

        // Проверка надежности пароля
        if (strlen($password) < 8 || !preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $password)) {
            return array(
                'success' => false,
                'message' => 'Пароль слишком слабый'
            );
        }

        // Дополнительная проверка на длину пароля для статуса 'perfect'
        if (strlen($password) >= 12) {
            $password_check_status = 'perfect';
        } else {
            $password_check_status = 'good';
        }

        // Все проверки пройдены, регистрируем пользователя
        $query = "INSERT INTO users (email, password_hash) VALUES ($1, $2) RETURNING user_id";
        $result = pg_query_params($this->db_connection, $query, array($email, $password_hash));
        $row = pg_fetch_assoc($result);
        $user_id = $row['user_id'];


        // Генерация access token (JWT)
        $payload = array(
            'user_id' => (int)$user_id // После декодирования он будет отображён в JSON как "user_id":int_number
        );
        $access_token = JWTService::generateToken($payload, 15); // Используем метод generateToken

        // Возвращаем результат регистрации
        return array(
            'success' => true,
            'user_id' => (int)$user_id, // Приводим к типу int по условию задания
            'access_token' => $access_token,
            'password_check_status' => $password_check_status
        );
    }

    public function authorizeUser($email, $password): array
    {
        $query = "SELECT user_id, password_hash FROM users WHERE email = $1";
        $result = pg_query_params($this->db_connection, $query, array($email));
        if (!$result) {
            return array(
                'success' => false,
                'message' => 'Ошибка выполнения запроса: ' . pg_last_error($this->db_connection)
            );
        }

        if (pg_num_rows($result) === 0) {
            return array(
                'success' => false,
                'message' => 'Пользователь с таким email не найден'
            );
        }

        $row = pg_fetch_assoc($result);
        $password_hash = $row['password_hash'];

        if (!password_verify($password, $password_hash)) {
            return array(
                'success' => false,
                'message' => 'Неверный пароль'
            );
        }



        // Проверка надежности пароля
        if (strlen($password) < 8 || !preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $password)) {
            return array(
                'success' => false,
                'message' => 'Пароль слишком слабый'
            );
        }

        // Дополнительная проверка на длину пароля для статуса 'perfect'
        if (strlen($password) >= 12) {
            $password_check_status = 'perfect';
        } else {
            $password_check_status = 'good';
        }


        $user_id = $row['user_id'];

        // Генерация access token (JWT)
        $payload = array(
            'user_id' => (int)$user_id // После декодирования он будет отображён в JSON как "user_id":int_number
        );
        $access_token = JWTService::generateToken($payload, 15); // Используем метод generateToken

        return array(
            'success' => true,
            'user_id' => (int)$user_id, // Приводим к типу int по условию задания
            'access_token' => $access_token,
            'password_check_status' => $password_check_status
        );
    }
}
?>
