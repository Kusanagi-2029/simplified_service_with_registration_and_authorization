//register.php
<?php

require_once './src/controllers/UserController.php';
require_once './src/view/authorizedAndRegistered.php';

$userController = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $registrationResult = $userController->registerUser($email, $password);
    $view = new AuthorizedAndRegistered();
    if ($registrationResult['success']) {
        $view->showRegistrationSuccess($registrationResult['user_id'], $email, $registrationResult['password_check_status'], $registrationResult['access_token']);
    } else {
        $view->showError($registrationResult['message']);
    }
} else {
    http_response_code(405); // Метод не разрешен
}
?>
