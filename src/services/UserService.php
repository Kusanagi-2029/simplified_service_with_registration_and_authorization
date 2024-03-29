//services/UserService.php
<?php
require_once 'UserRepository.php';

class UserService {
    private UserRepository $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function registerUser($user): array
    {
        return $this->userRepository->registerUser($user);
    }

    public function authorizeUser($email, $password): array
    {
        return $this->userRepository->authorizeUser($email, $password);
    }
}
?>
