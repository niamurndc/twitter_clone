<?php 
include('db.php');
session_start();
if($_SESSION['uname'] == ''){
  header('location: login.php');
}
$uname = $_SESSION['uname'];

if(isset($_POST['submit'])){
  $text = $_POST['post'];
  $username = $uname;

  $query = "INSERT INTO posts (text, username) VALUES ('$text', '$username')";
  $create = mysqli_query($conn, $query);
  if($create){
    header('location: index.php');
  }else{
    echo 'Post is not submitted';
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
      <div class="col-md-6 col-6">
        <div class="d-flex align-items-center ">
          <img class="mr-3" src="pubglogo.jpg" alt="" width="48" height="48">
          <div class="lh-100">
            <a href="profile.php"><h6 class="mb-0 text-white lh-100">Bootstrap</h6></a>
            <small>Since 2011</small>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-6 text-right">
        <a href="index.php" class="btn btn-warning">Home</a>
      </div>
    </div>
    <div class="my-3 p-3 bg-white rounded shadow-sm">
      <div class="row">
        <form method="POST" class="col-md-12 m-1">
          <textarea name="post" rows="10" class="form-control"></textarea>
          <input type="submit" name="submit" value="Post" class="btn btn-primary mt-1">
        </form>
      </div>
    </div>
  </main>
</body>
</html>