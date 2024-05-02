<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>

<style>
  html, body {
    overflow: hidden;
    height: 100%;
  }
  
  body {
    background-image: url('libs/images/bg.webp') !important; /* Replace 'libs/images/bg.webp' with the actual path to your image */
    background-size: cover !important;
    background-position: center;
    margin: 0; /* Remove default body margin */
    padding: 0; /* Remove default body padding */
    position: relative; /* Add relative positioning */
  }

  /* Background overlay */
  body::after {
    content: "";
    background-color: rgba(189, 32, 37, 0.5); /* Red color with 50% opacity */
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1; /* Ensure it's above the background image */
  }

  .login-page {
    position: relative; /* Add relative positioning */
    z-index: 2; /* Ensure it's above the background overlay */
  }

  .logo {
    max-width: 100%;
    padding: 5%;
    height: auto;
  }
  .btn{
    width: 100%;
    background-color: #BD2025 !important;
  }
  .btn:hover{
    width: 100%;
    background-color: #FC3F4D !important;
  }
</style>

<div class="login-page">
    <div class="text-center">
       <img src="libs/images/red.png" class="logo" alt="Logo">
       <h1>Welcome</h1>
       <p>Sign in to start your session</p>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="auth.php" class="clearfix">
        <div class="form-group">
              <label for="username" class="control-label">Username</label>
              <input type="name" class="form-control" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="Password" class="control-label">Password</label>
            <input type="password" name= "password" class="form-control" placeholder="password">
        </div>
        <div class="form-group">
                <button type="submit" class="btn btn-info pull-right">Login</button>
        </div>
    </form>
</div>

<?php include_once('layouts/header.php'); ?>
