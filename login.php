<?php
require('config.php');
session_start();
$errormsg = "";
if (isset($_POST['email'])) {

  $email = stripslashes($_REQUEST['email']);
  $email = mysqli_real_escape_string($con, $email);
  $password = stripslashes($_REQUEST['password']);
  $password = mysqli_real_escape_string($con, $password);
  $query = "SELECT * FROM `users` WHERE email='$email'and password='" . md5($password) . "'";
  $result = mysqli_query($con, $query) or die(mysqli_error($con));
  $rows = mysqli_num_rows($result);
  if ($rows == 1) {
    $_SESSION['email'] = $email;
    header("Location: index.php");
  } else {
    $errormsg  = "Wrong";
  }
} else {
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.css" rel="stylesheet">
  <style>
    .login-form {
      width: 560px;
      margin: 50px auto;
      font-size: 18px;
    }

    .login-form form {
      margin-bottom: 18px;
      background: #56B870;
      box-shadow: 1px 2px 2px rgba(0, 0, 0, 0.3);
      padding: 30px;
      border: 1px solid #ddd;
    }

    .login-form h2 {
      color: #0A2F51;
      margin: 0 0 18px;
      position: relative;
      text-align: center;
    }

    .login-form h2:before {
      left: 0;
    }

    .login-form h2:after {
      right: 0;
    }

    .login-form .hint-text {
      color: #0A2F51;
      margin-bottom: 30px;
      text-align: center;
    }

    .login-form .description {
      color: #0A2F51;
      margin-top: 20px;
      text-align: center;
    }

    .login-form a:hover {
      text-decoration: slateblue;
    }

    .form-control,
    .btn {
      min-height: 38px;
      border-radius: 2px;
    }

    .btn {
      font-size: 15px;
      font-weight: bold;
    }
  </style>
</head>

<body>
  <style <!doctype html>
  <html>
  <head>
  <style>
  h1
  {
  background-color:#DEEDCF;
  }
  p
  {
  background-color:;
  }
  body
  {

  background-color:#DEEDCF;
  background-color: #DEEDCF;

  }
  </style>
  </head>
  <body>
  <h1>Beta</h1>
  <p></p>
  <div style="text-align: center;">
    <img src="https://www.ifheindia.org/assets/img/ifhe-logo.svg" width="350px" height="100px" alt="IFHE Logo">
</div>
  </body>
  </html>
  <div class="login-form">
    <form action="" method="POST" autocomplete="off">
      <h2 class="text-center">Personal Expense Tracker</h2>
      <p class="hint-text">Login Panel</p>
      <p class="description">Project Made By Aditya Shenvi 353 , Sneha Sah 335 
        , Aashritha Adoni 352</p>
      <div class="form-group">
        <input type="text" name="email" class="form-control" placeholder="Email" required="required">
      </div>
      <div class="form-group">
        <input type="password" name="password" class="form-control" placeholder="Password" required="required">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-success btn-block" style="border-radius:0%;">Login</button>
      </div>
    </form>
    <p class="text-center">Don't have an account?<a href="register.php" class="text-danger"> Register Here</a></p>
  </div>
</body>
<!-- Bootstrap core JavaScript -->

<script src="js/bootstrap.min.js"></script>
<script src="js/feather.min.js"></script>
<!-- Menu Toggle Script -->
<script>
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });
</script>
<script>
  feather.replace()
</script>

</html>