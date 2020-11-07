<?php include './functions.php';
    if(!isAdmin()){
        $_SESSION['success']="Ssh! Log In as Admin to access that page.";
        header('location: ./index.php');
    }
?>
<!doctype html>
<html lang="en">

  <?php
    $title = "Home Page";
    include('./includes/head.php');
    ?>
  <body>
    <!-- Navigation Bar -->
    <?php include('./includes/navbar.php'); ?>

    <div class="container mt-4">
        <div class="card bg-light">
            <article class="card-body mx-auto" style="width: 400px;">
                <h4 class="card-title mt-3 text-center">Release a Train</h4>
                <form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post" id="bookingForm">
                <?php display_errors();?>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-train"></i> </span>
                        </div>
                        <input name="train" class="form-control" placeholder="Train No." type="number" min=0>
                    </div>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                        </div>
                        <input name="date" class="form-control" placeholder="Date of Journey" type="date" min=<?php echo date('Y-m-d');?> >
                    </div>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <img src="./images/ac.jpg" width="16" height="16"> </span>
                        </div>
                        <input name="ac" class="form-control" placeholder="AC Coaches" type="number" min=0>
                    </div>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <img src="./images/fan.jpg" width="16" height="16"> </span>
                        </div>
                        <input name="sl" class="form-control" placeholder="Sleeper Coaches" type="number" min=0>
                    </div>
                </form>
                <div class="form-group">
                    <button type="submit" form="bookingForm" formaction=<?php echo $_SERVER['PHP_SELF'];?> formmethod="post" class="btn btn-info btn-block">Release</button>
                </div>
            </article>
        </div> 
    </div> 
    <?php print_r($_POST);?>
    <div class="container">
        <?php include './includes/footer.php'; ?>
    </div>
    
  </body>
</html>