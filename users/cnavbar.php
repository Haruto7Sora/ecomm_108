<?php

?>
<nav class="navbar navbar-expand-lg navbar-light bg-light border border-1 border-primary bg-success p-2 text-white bg-opacity-75">
  <div class="container-fluid">
    <a class="navbar-brand mx-5" href="#"><img style="width:5vw; height:10vh;" src="profile/logo.jfif" alt="company logo"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mx-3" id="navbarNavAltMarkup">
      <div class="navbar-nav  d-flex align-items-center mx-3">
        <a class="nav-link active" aria-current="page" href="#">Home</a>
        <a class="nav-link" href="#">Features</a>
        <a class="nav-link" href="#">Pricing</a>
        <?php if (!isset($_SESSION['customerEmail']) && !isset($_SESSION['clogin'])) { ?>
          <a class="nav-link" href="clogin.php">Customer Login</a>
        <?php } else { ?>
          <!--<div class="d-flex flex-end"> -->
          <img class="nav-link"  style="width:10vh; height: auto;" src="<?php echo $_SESSION['profile']; ?>" alt="Profile Image">
          <p  class="nav-link"><?php echo $_SESSION['customerEmail']; ?></p>
          <a class="nav-link" href="clogout.php">Logout</a>
          </div>
        <?php  } ?>
      </div>
    </div>


  </div>
</nav>