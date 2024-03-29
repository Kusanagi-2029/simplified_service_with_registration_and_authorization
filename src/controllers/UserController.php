//controllers/UserController.php
<?php
require_once './src/models/User.php';
require_once './src/services/UserService.php';

class UserController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function registerUser($email, $password): array
    {
        $user = new User($email, $password);
        return $this->userService->registerUser($user);
    }

    public function authorizeUser($email, $password): array
    {
        return $this->userService->authorizeUser($email, $password);
    }
}

?>
