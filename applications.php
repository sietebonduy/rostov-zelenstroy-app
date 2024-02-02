<?php
include 'db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <title>Login</title>
</head>
<body class="bg-light w-100 h-100">
<div class="d-flex justify-content-end gap-2 mt-2 mx-3">
    <form action="index.php">
      <input class="btn btn-primary" type="submit" value="Главная">
    </form>
    <form action="login.php">
      <input class="btn btn-danger" type="submit" value="Выход из аккаунта">
    </form>
  </div>
  <div class="container d-flex flex-column justify-content-center align-items-center my-5">
  <h1 class="mb-3 text-success">Заявки</h1>
  <?php
    if ($_SESSION['role'] == 'admin') {
      ?> 
      <table class="border border-3 border-dark mt-5 w-100 text-white">
        <thead class="bg-primary">
          <tr>
            <th class="border-bottom border-3 border-dark p-2">Username</th>
            <th class="border-bottom border-3 border-dark p-2">Email</th>
            <th class="border-bottom border-3 border-dark p-2">Confirm</th>
          </tr>
        </thead>
        <tbody class="bg-secondary">
        <!-- class="border-bottom border-3 border-dark p-2" -->
      <?php
      $query = "SELECT * FROM Users WHERE role='guest'";
      $result = $mysqli->query($query);
      while($row = mysqli_fetch_array($result)) {
        ?> 
          <tr>
            <td class="border-bottom border-3 border-dark p-2"><?php echo $row['username'];?></td>
            <td class="border-bottom border-3 border-dark p-2"><?php echo $row['email'];?></td>
            <td class="border-bottom border-3 border-dark p-2">
              <form action="" method="get">
                <button type="submit" name="id" value="<?php echo $row['id']; ?>" class="w-100 h-100 btn btn-secondary border border-0">
                  <svg fill="#fff" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="64px" height="64px" viewBox="0 0 70 70" enable-background="new 0 0 70 70" xml:space="preserve" stroke="#fff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M58.582,11.456c0.979,0,1.967,0.333,2.779,1.015c1.823,1.527,2.073,4.231,0.56,6.038l-30.5,36.383 c-0.833,0.993-3.233,3.652-3.233,3.652s-2.053-2.032-3.191-3.309L8.394,39.479c-1.703-1.63-1.753-4.344-0.11-6.064 c0.852-0.892,1.991-1.342,3.128-1.342c1.058,0,2.113,0.389,2.934,1.174l13.361,12.661l27.611-32.935 C56.156,11.972,57.362,11.456,58.582,11.456 M58.582,7.456c-2.453,0-4.761,1.075-6.331,2.948L27.373,40.081l-10.276-9.737 c-1.525-1.46-3.549-2.271-5.684-2.271c-2.261,0-4.456,0.939-6.021,2.579C2.23,33.964,2.337,39.22,5.628,42.369l16.497,15.657 c1.22,1.351,3.163,3.276,3.247,3.36c0.75,0.742,1.762,1.157,2.814,1.157c0.037,0,0.074-0.001,0.112-0.002 c1.093-0.03,2.125-0.507,2.856-1.317c0.101-0.111,2.46-2.726,3.329-3.763l30.501-36.384c1.423-1.698,2.094-3.851,1.889-6.062 c-0.203-2.198-1.249-4.191-2.945-5.612C62.433,8.148,60.533,7.456,58.582,7.456L58.582,7.456z"></path> </g> <g> <path d="M54.491,20.763c-0.225,0-0.45-0.075-0.637-0.23c-0.426-0.353-0.484-0.982-0.132-1.407l2.063-2.488 c0.352-0.425,0.982-0.485,1.407-0.132c0.426,0.353,0.484,0.982,0.132,1.407L55.262,20.4C55.064,20.64,54.779,20.763,54.491,20.763 z"></path> </g> <g> <path d="M42.292,34.891c-0.236,0-0.474-0.083-0.664-0.253c-0.413-0.366-0.45-0.999-0.083-1.411l9.834-11.063 c0.366-0.414,0.999-0.451,1.411-0.083c0.413,0.366,0.45,0.999,0.083,1.411l-9.834,11.063 C42.842,34.777,42.567,34.891,42.292,34.891z"></path> </g> </g> </g></svg>
                </button>
              </form>
            </td>
          </tr>
        <?php
          $id = $_GET['id'];
          $query = "UPDATE Users SET role = 'operator' WHERE id=$id";
          if ($mysqli->query($query) === TRUE) {
            header("Location: applications.php");
          }
      }
    } else {
      header ('Location: index.php');
      exit();
    }
  ?>
        </tbody>
      </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  
</body>
</html>