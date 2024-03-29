//models/User.php
<?php
class User {
    private string $email;
    private string $password;

    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

}
?>
