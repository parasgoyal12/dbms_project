<?php include 'functions.php';
    if(!isset($_SESSION['user'])){
        $_SESSION['success']="You must log in first.";
        header('location: location.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php
    $title="List Tickets";
    include './includes/head.php';?>
<body>
<?php include './includes/navbar.php';?>
    <main role="main">
        <div class="row my-4">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="container"><?php
                $tickets=[
                    ["PNR"=>1,"Date"=>"2020-10-1","Train"=>123],
                    ["PNR"=>2,"Date"=>"2020-10-2","Train"=>125],
                    ["PNR"=>3,"Date"=>"2020-10-3","Train"=>124]
                ];
                // $tickets=array();
                if(count($tickets)==0){
                    echo '<h1>No tickets booked so far!!</h1>';
                }
                else{
                    echo "<ul class='list-group list-group-flush'>";
                foreach($tickets as $ticket)
                {
                    echo("<a class='list-group-item list-group-item-action' href='#'>");
                    echo "Ticket No. ".$ticket["PNR"].' Booked on train '.$ticket['Train'].' for '.$ticket["Date"];
                    echo "</a>";
                }
                echo "</ul>";
                
                }
                ?></div>
            </div>
        </div>
    </main>
    <?php include "./includes/footer.php";?>
</body>
</html>