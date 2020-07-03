<?php 
include('db.php');
session_start();

if(isset($_POST['login'])){
  echo 'submit';
  $uname = $_POST['username'];
  $pass = $_POST['password'];

  $query = "SELECT * FROM users WHERE username = '$uname' && pass = '$pass'";
  $result = mysqli_query($conn, $query);
  $login = mysqli_num_rows($result);
  if($login == 1){
    $_SESSION['uname'] = $uname;
    header('location: index.php');
  }else{
    echo 'Your information is not correct';
  }
}

if(isset($_POST['signup'])){
  $name = $_POST['name'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $cpassword = $_POST['cpassword'];

  if($password == $cpassword){
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $num = mysqli_num_rows($result);
    if($num < 1){
      $query = "SELECT * FROM users WHERE email = '$email'";
      $result = mysqli_query($conn, $query);
      $em = mysqli_num_rows($result);
      if($em < 1){
        $query1 = "INSERT INTO users (name, username, email, pass, image) VALUES ('$name', '$username', '$email', '$password', 'pubglogo.jpg')";
        $create = mysqli_query($conn, $query1);
        if($create){
          $_SESSION['uname'] = $username;
          header('location: index.php');
        }else{
          echo 'not created';
        }
      }
    }
  }


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <title>Inventory</title>
</head>
<body>
  <main role="main" class="container">
    <div class="row p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
      <div class="col-md-6">
            <h6 class="mb-0 text-white lh-100">Bootstrap</h6>
            <small>Since 2011</small>
      </div>
      <div class="col-md-6 text-right">
        <form class="form-inline my-2" method="post">
          <input class="form-control mr-sm-2" name="username" type="text" placeholder="Username">
          <input class="form-control mr-sm-2" name="password" type="password" placeholder="Password">
          <button class="btn btn-outline-warning my-2 my-sm-0" name="login" type="submit">Login</button>
        </form>
      </div>
    </div>
    <div class="my-3 p-3 bg-white rounded shadow-sm">
      <div class="row">
        <div class="col-md-6">
          <h4 class="border-bottom border-gray pb-2 mb-0">Create Your Account</h4>
            <form method="post">
              <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" name="name" id="name" class="form-control">
              </div>
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control">
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control">
              </div>
              <div class="form-group">
                <label for="cpassword">Confirm Password</label>
                <input type="password" name="cpassword" id="cpassword" class="form-control">
              </div>
              <input type="submit" value="Sign Up" name="signup" class="btn btn-primary">
            </form>
        </div>
        <div class="col-md-6"></div>
      </div>
      
    </div>
  </main>
</body>
</html>