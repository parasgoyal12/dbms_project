<!doctype html>
<html lang="en">
    <?php
        $title = "Login";
        include('./includes/head.php');
    ?>
  <body>
    <?php
        include('./includes/navbar.php');
    ?>
    <div class="container mt-1">
        <div class="card bg-light">
            <article class="card-body mx-auto" style="max-width: 400px;">
                <h4 class="card-title mt-3 text-center">Create Account</h4>
                <form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <input name="email" class="form-control" placeholder="Email address" type="email">
                    </div> <!-- form-group// -->
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input name="password" class="form-control" placeholder="Password" type="password">
                    </div> <!-- form-group// -->                                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block"> Log In  </button>
                    </div> <!-- form-group// -->      
                    <p class="text-center">Need an account? <a href="./register.php">Register</a> </p>                                                                 
                </form>
            </article>
        </div> 
    </div> 
    <?php print_r($_POST);?>

</body>
</html>