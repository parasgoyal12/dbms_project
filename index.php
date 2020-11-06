<!doctype html>
<html lang="en">

  <?php
    $title = "Home Page";
    include('./includes/head.php');
    ?>
  <body>
    <!-- Navigation Bar -->
    <?php
        include('./includes/navbar.php');
    ?>

    <main role="main">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img class="d-block w-100" src="images/1.jpg" alt="First slide">
                </div>
                <div class="carousel-item">
                <img class="d-block w-100" src="images/2.jpg" alt="Second slide">
                </div>
                <div class="carousel-item">
                <img class="d-block w-100" src="images/3.jpg" alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    <div class="container my-4">
    <!-- Example row of columns -->
        <div class="row">
        <div class="col-md-4">
            <h2>Book Tickets</h2>
            <p>Select from the pool of available trains and book your tickets for the next journey. </p>
            <p><a class="btn btn-secondary" href="#" role="button">Book Ticket &raquo;</a></p>
        </div>
        <div class="col-md-4">
            <h2>Ticket Details</h2>
            <p>Have a PNR Number? Check the details of the passengers here. </p>
            <p><a class="btn btn-secondary" href="#" role="button">Passenger Details &raquo;</a></p>
        </div>
        <div class="col-md-4">
            <h2>Admin</h2>
            <p>Login Right Here to get admin access and add new train details.</p>
            <p><a class="btn btn-secondary" href="#" role="button">Login &raquo;</a></p>
        </div>
        </div>

        <hr>

    </div> 
    </main>
    <?php include './includes/footer.php'?>

   

    
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    

  </body>
</html>