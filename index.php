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


if(isset($_POST['follow'])){
  $follower = $_POST['followers'];

  $query = "INSERT INTO follow (following, followers) VALUES ('$uname', '$follower')";
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
            ?>
          <img class="mr-3" src="<?php echo $img; ?>" alt="" width="48" height="48">
          <div class="lh-100">
            <a href="profile.php"><h6 class="mb-0 text-white lh-100"><?php echo $uname; ?></h6></a>
            <small>Since <?php echo $year; ?></small>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-6 text-right">
        <a href="create.php" class="btn btn-warning">Create</a>
      </div>
    </div>
    <div class="my-3 p-3 bg-white rounded shadow-sm">
      <h6 class="border-bottom border-gray pb-2 mb-0">Suggestions</h6>
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
        if($follower1 == $follower){
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
    <div class="my-3 p-3 bg-white rounded shadow-sm">
      <h6 class="border-bottom border-gray pb-2 mb-0">Recent updates</h6>
      <?php 
        $query = "SELECT * FROM posts";
        $result = mysqli_query($conn, $query);

        $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach($posts as $post){
          $follower = $post['username'];
          if($follower == $uname){
            ?>
            <div class="media text-muted pt-3">
              <img src="pubglogo.jpg" alt="pubglogo" width="36" height="36" class="mt-1 mr-2">
              <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <strong class="d-block text-gray-dark">@<?php echo $post['username']; ?></strong>
                <?php echo $post['text']; ?>
              </p>
            </div>
          <?php
          }else{
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
        <img src="pubglogo.jpg" alt="pubglogo" width="36" height="36" class="mt-1 mr-2">
        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
          <strong class="d-block text-gray-dark">@<?php echo $post['username']; ?></strong>
          <?php echo $post['text']; ?>
        </p>
      </div>
      <?php }} } ?>
    </div>
  
    
  </main>
</body>
</html>
<?php

// [x]index.php show popular twits first time // after show your follow (timeline)
// [x]profile.php show your bio follower following
// [x]post.php show single post
// [x]login.php/sign up for user login and sign up

// Backend
// [x]user table (username, name, email, password, image)
// [x]post (title, body, userid, visible)
// [x]comment (userid, postid, text)
// [x]follow (userid, 5 follower, followersid )

