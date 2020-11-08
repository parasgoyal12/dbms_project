<?php include './functions.php';
    if(!isAdmin()){
        $_SESSION['success']="Ssh! Log In as Admin to access that page.";
        header('location: ./index.php');
    }
    
    if(isset($_POST['Release'])){
        release();
    }
    function release(){
        global $errors, $db;
        $train_no = e($_POST['train']);
        $date = e($_POST['date']);
        $sleeper = e($_POST['sl']);
        $ac = e($_POST['ac']);
        if (empty($train_no)) { 
            array_push($errors, "Train Number is required"); 
        }
        if (empty($date)) { 
            array_push($errors, "Release Date is required"); 
        }
        if (empty($sleeper)) { 
            array_push($errors, "Please Specify the Number of Sleeper Coaches"); 
        }
        if (empty($ac)) { 
            array_push($errors, "Please Specify the Number of Sleeper Coaches"); 
        }
        if(count($errors)==0){
            $insert_query = "INSERT INTO train (train, date, ac, sleeper)
                     VALUES ('$train_no', '$date', $ac , $sleeper)";
            if(!mysqli_query($db, $insert_query)){
                print_r ($db->error);
            }
            $_SESSION['train_insert_success']  = "Train Number $train_no released for $date";
            // header('location: ./admin.php');	
        }
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
                <div class="d-flex justify-content-center my-2"><?php
                        if(isset($_SESSION['train_insert_success'])){
                        echo '<div class="alert alert-success">';
                        echo $_SESSION['train_insert_success'];
                        echo "</div>";
                        unset($_SESSION['train_insert_success']);
                    }        ?></div>
                <form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
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
                    <div class="form-group">
                        <button type="submit" class="btn btn-info btn-block" name="Release">Release</button>
                    </div>
                </form>
            </article>
        </div> 
    </div> 
    <?php $_POST;?>
    <div class="container">
        <?php include './includes/footer.php'; ?>
    </div>
    
  </body>
</html>