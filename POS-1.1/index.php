<?php
include('connect.php');
if(isset($_POST['btn']))
{  
  $name = $_POST['username'];
  $pass = $_POST['password'];

  $result = mysqli_query($con,"SELECT * FROM user WHERE username='$name' AND password='$pass'");
  if (mysqli_num_rows($result)>0) {
    session_start();
    $fetch = mysqli_fetch_array($result);
    $_SESSION['id'] = $fetch['id'];
    $_SESSION['name'] = $name;
    $_SESSION['type'] = $fetch['type'];
    if($fetch['type']=="Kitchen"){
      header('Location:menu.php');
    } else if($fetch['type']=="SaleCounter"){
      header('Location:menu.php');
    } else {
      header('Location:menu.php');
    }
    
  } 
  else {
    echo '<script type="text/javascript">alert("Credentials are Invalid!");</script>';
  }
  

}?>

<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>POS</title>
  
<link rel='stylesheet prefetch' href='assets/css/font-awesome.min.css'>

      <link rel="stylesheet" href="assets/css/style.css">

  
</head>

<body style="background-image: url('back.jpg');">

  
<!-- Form Mixin-->
<!-- Input Mixin-->
<!-- Button Mixin-->
<!-- Pen Title-->

<div class="pen-title" style="margin-top: 12%;">
  
<!-- Form Module-->
<div class="module form-module">
  <div class="toggle">
    
  </div>

  <div class="form">
    <h2>Login to your account</h2>
    <form  method="POST" name="loginForm" id="loginId">
    <input type="text" name="username" placeholder="Username" autofocus>
    <input type="password" name="password" placeholder="Password">
    <button name="btn">Login</button>
    </form>
  </div>
  

</body>
</html>
<!-- <script type="text/javascript">
function login()
         {
            if((document.loginForm.username.value=="admin") &&(document.loginForm.password.value=="123"))
          {
            
             return true;
          }
          else
          {
            alert("Username/Password Miss Matched");
            return false;
          }
          
        }
</script> -->