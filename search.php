<?php include './functions.php';
    if(!isLoggedIn()){
        $_SESSION['success']="You must log in first";
        header('location: ./login.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title='Search Train';
include('./includes/head.php');
?>
<body>
    <?php include './includes/navbar.php';?>
    <div class="container">
        <div class="row m-2" >
            <div class="col-4" >
                <div class="container-fluid border border-dark bg-light m-1" style="height:40em;">
                    <form class='m-1' action="./search.php" method="POST">
                    <input type="submit" class="btn btn-outline-info" value="Submit" name="Submit">
                    </form>
                </div>
            </div>
            <div class="col-8">
                <div class="container-fluid bg-light m-1 border border-dark" style="height:40em;overflow-y:scroll;">

                </div>
            </div>
        </div>
    </div>
<?php include('./includes/footer.php');?>
<script src="./assets/booking.js"></script>
</body>
</html>
