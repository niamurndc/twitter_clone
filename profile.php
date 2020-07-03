<?php
include('db.php');
session_start();
if($_SESSION['uname'] == ''){
  header('location: login.php');
}
$uname = $_SESSION['uname'];

if(isset($_POST['unfollow'])){
  $follower = $_POST['followers'];

  $query = "DELETE FROM follow WHERE following = '$uname' && followers = '$follower'";
  mysqli_query($conn, $query);
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
        <?php 
              $query = "SELECT * FROM users WHERE username = '$uname'";
              $result2 = mysqli_query($conn, $query);
              $user = mysqli_fetch_assoc($result2);
              $img = $user['image'];
              $year = date('Y', strtotime($user['created']));
              $name = $user['name'];
            ?>
          <img class="mr-3" src="<?php echo $img; ?>" alt="" width="48" height="48">
          <div class="lh-100">
            <h6 class="mb-0 text-white lh-100"><?php echo $uname; ?></h6>
            <small>Since <?php echo $year; ?></small>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-6 text-right">
        <a href="index.php" class="btn btn-warning">Home</a>
      </div>
    </div>
    <div class="my-3 p-3 bg-white rounded shadow-sm">
      <div class="row">
        <div class="col-md-3 text-center">
          <img src="<?php echo $img; ?>" alt="pubglogo" width="160" height="160"><br>
          <a href="#" class="btn btn-sm mt-2 btn-outline-primary">Edit Profile</a>
          <a href="logout.php" class="btn btn-sm mt-2 btn-outline-primary">Sign Out</a>
        </div>
        <div class="col-md-9">
          <h2><?php echo $name; ?></h2>
          <h4>@<?php echo $uname; ?></h4>
          <?php
          $query = "SELECT * FROM follow WHERE followers = '$uname'";
          $result = mysqli_query($conn, $query);
          $follow2 = mysqli_num_rows($result);
          ?>
          <span class="badge badge-primary"><?php echo $follow2; ?> Followers</span>
          <?php
          $query = "SELECT * FROM follow WHERE following = '$uname'";
          $result = mysqli_query($conn, $query);
          $follow = mysqli_num_rows($result);
          ?>
          <span class="badge badge-primary"><?php echo $follow; ?> Following</span>
        </div>
      </div>
    </div>
    <div class="my-3 p-3 bg-white rounded shadow-sm">
      <h6 class="border-bottom border-gray pb-2 mb-0">Your are following</h6>
      <?php 
        $query = "SELECT * FROM users";
        $result = mysqli_query($conn, $query);

        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach($users as $user){
          if($user['username'] == $uname){
      ?>

      <div class="div sr-only"></div>

      <?php }else{   
        $follower = $user['username'];
        $query = "SELECT * FROM follow WHERE following = '$uname' && followers = '$follower'";
        $result = mysqli_query($conn, $query);
        $follow = mysqli_fetch_assoc($result);
        $follower1 = $follow['followers'];
        if($follower1 != $follower){
      ?>
        <div class="div sr-only"></div>
      <?php
        }else{
      ?>
      <div class="media text-muted pt-3">
        <img src="<?php echo $user['image']; ?>" alt="pubglogo" width="36" height="36" class="mt-1 mr-2">
        <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
          <div class="d-flex justify-content-between align-items-center w-100">
            <strong class="text-gray-dark">@<?php echo $user['username']; ?></strong>
            <form method="post">
              <input type="text" name="followers" value="<?php echo $user['username']; ?>" class="sr-only">
              <?php
                $follower = $user['username'];
                $query = "SELECT * FROM follow WHERE following = '$uname' && followers = '$follower'";
                $result = mysqli_query($conn, $query);
                $follow = mysqli_num_rows($result);
                if($follow >= 1){
              ?>
              <input type="submit" value="Unfollow" name="unfollow" class="btn btn-outline-primary">
              <?php }else{
              ?>
              <input type="submit" value="Follow" name="follow" class="btn btn-primary">
              <?php }
              ?>
            </form>
          </div>
        </div>
      </div>
      <?php } } }?>
    </div>
  </main>
</body>
</html>