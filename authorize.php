//authorize.php
<?php
require_once './src/controllers/UserController.php';
require_once './src/view/authorizedAndRegistered.php';

$userController = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $authorizationResult = $userController->authorizeUser($email, $password);
    $view = new AuthorizedAndRegistered();
    if ($authorizationResult['success']) {
        $view->showAuthorizationSuccess($authorizationResult['user_id'], $email, $authorizationResult['password_check_status'], $authorizationResult['access_token']);
    } else {
        $view->showError($authorizationResult['message']);
    }
} else {
    http_response_code(405); // Метод не разрешен
}
?>