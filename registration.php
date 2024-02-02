<?php
include 'db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  $emailExistsQuery = "SELECT id FROM Users WHERE email = '$email'";
  $result = $mysqli->query($emailExistsQuery);

  if ($result && $result->num_rows > 0) {
    $errorMessage = 'Пользователь с таким email уже существует.';
  } else {
    if (
        !empty($username) && !empty($email) && !empty($password) &&
        strlen($username) <= 20 && 
        strlen($email) <= 30 &&
        strlen($password) <= 25 &&
        filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {
        $username = $mysqli->real_escape_string($username);
        $email = $mysqli->real_escape_string($email);
        $password = $mysqli->real_escape_string($password);

        $query = "INSERT INTO `Users` (`id`, `username`, `email`, `password`) VALUES (NULL, '$username', '$email', '$hashedPassword')";

        if ($mysqli->query($query) === TRUE) {
            header('Location: index.html');
            exit();
        } else {
            echo 'Ошибка: ' . $mysqli->error;
        }
    } else {
      $errorMessage = 'Все поля должны быть заполнены и соответствовать длинам. Проверьте также формат email.';
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <title>Ростовзеленстрой</title>
</head>
<body class="bg-light w-100 h-100">
  <div class="d-flex justify-content-end gap-2 mt-2 mx-3">
    <form action="index.html">
      <input class="btn btn-primary" type="submit" value="Главная">
    </form>    
  </div>
  <div class="container d-flex flex-column justify-content-center align-items-center my-5">
  <h3 class="mb-3">Регистарция</h3>
  <form action="" method="post" class="col-3 border border-3 border-success-subtle rounded p-3">
    <div class="mb-3">
      <label for="username" class="w-100">Введите имя</label></br>
      <input type="text" name="username" class="w-100" placeholder="username" size="20">
    </div>
    <div class="mb-3">
      <label for="email" class="w-100">Введите эл. почту</label></br>
      <input type="demail" name="email" class="w-100" placeholder="sometext@domen.su" size="30">
    </div>
    <div class="mb-4">
      <label for="password" class="w-100">Введите пароль</label></br>
      <input type="password" name="password" class="w-100" placeholder="password" size="25">
    </div>
    <div>
      <input class="btn btn-success w-100" type="submit" value="Зарегистрироваться" class="w-25">
    </div>
  </form>
  <?php
    if (isset($errorMessage)) {
      echo "<div class='text-danger mt-5'>$errorMessage</div>";
    }
  ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>