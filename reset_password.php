<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include 'db.php';
session_start();

$email = $_POST['email'];

if (isset($_POST['reset_btn'])) {
  $mail = new PHPMailer(true);
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'den768653@gmail.com';
  $mail->Password = 'iusn jyws cajw zmry ';
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 465;

  $mail->setFrom('den768653@gmail.com');
  $mail->addAddress($email);
  $mail->isHTML(true);

  $query = "SELECT * FROM Users WHERE email = '$email'";
  $result = $mysqli->query($query);

  if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id = $row["id"];

    $reset_token = bin2hex(random_bytes(16));
    $query = "UPDATE Users SET reset_token = '$reset_token' WHERE id = $id";
    $mysqli->query($query);

    $reset_link = "localhost:8890/lab_4/reset_password_confirm.php?token=$reset_token";
    $subject = "Восстановление пароля";
    $message = "<h3>Для восстановления пароля перейдите по ссылке:</h3><p>$reset_link</p>";
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->send();

    echo "<script>alert('Инструкции по восстановлению пароля отправлены на вашу почту.')</script>";
  } else {
    echo "<script>alert('Пользователь с таким email не найден.')</script>";
    // echo "Пользователь с таким email не найден.";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <title>Login</title>
</head>
<body class="bg-light w-100 h-100">
  <div class="d-flex justify-content-end gap-2 mt-2 mx-3">
    <form action="index.html">
      <input class="btn btn-primary" type="submit" value="Главная">
    </form>    
  </div>
  <div class="container d-flex flex-column justify-content-center align-items-center my-5">
  <h3 class="mb-3">Восстановление пароля</h3>
  <form action="" method="post" class="col-3 border border-3 border-success-subtle rounded p-3">
    <div class="mb-3">
      <label for="email" class="w-100">Введите эл. почту:</label></br>
      <input required type="email" name="email" class="w-100">
    </div>
    <div class="mb-3">
      <input type="submit" value="Восстановить" class="w-100 btn btn-success" name="reset_btn">
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