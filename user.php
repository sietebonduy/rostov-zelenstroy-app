<?php 

abstract class AUser {
  abstract public function showInfo();
}

class User extends AUser{
  public $login;
  public $email;
  public $password;

  public function __construct($login = "", $password = "", $email = "") {
    if (empty($login) || empty($password) || empty($email)) {
      throw new InvalidArgumentException("Все данные о пользователе должны быть переданы.");
    }
    $this->login = $login;
    $this->password = $password;
    $this->email = $email;
  }
  public function __clone() {
    $this->name = "Guest";
    $this->login = "guest";
    $this->password = "qwerty";
}


  public function getLogin() {
    return $this->login;
  }
  public function getPassword() {
    return $this->email;
  }

  public function getEmail() {
    return $this->password;
  }

  public function showInfo() {
    echo "Login: " . $this->login . "<br>";
    echo "Password: " . $this->password . "<br>";
    echo "Email: " . $this->email . "<br>";
  }

}

class SuperUser extends User {
  private $role;

  public function __construct($login, $password, $email, $role) {
      parent::__construct($login, $password, $email);
      $this->role = $role;
  }

  public function getRole() {
      return $this->role;
  }

  public function showInfo() {
      parent::showInfo();
      echo "Role: " . $this->getRole() . "<br>";
  }
}


try {
  // Создаем экземпляр класса User без передачи аргументов (должно вызвать исключение)
  // $user = new User();
  $user = new User("example_user", "password123", "user@example.com");
  // $user->showInfo();

  // $superUser = new SuperUser("admin_user", "admin_password", "admin@example.com", "admin");
  // $superUser->showInfo();
} catch (InvalidArgumentException $e) {
  echo "Exception: " . $e->getMessage();
}

$user1 = clone $user;
$user1->showInfo();
?>