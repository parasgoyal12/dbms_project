<?php
    $title = "Home Page";
    include('../includes/head.php');
?>
<div class="container">
<?php
    $user = 'root';
    $pass = '';
    $db = 'dbms_pro';
    $db_conn = new mysqli('localhost', $user, $pass, $db) or die("Unable To Connect");
    
    
    $db_conn->query("DROP TABLE train");
    $db_conn->query("DROP TABLE train_info");
    $db_conn->query("DROP TABLE passenger");
    $db_conn->query("DROP TABLE ticket");
    $db_conn->query("DROP TABLE users");
    $db_conn->query("DROP TABLE ac_coach");
    $db_conn->query("DROP TABLE sleeper_coach");
    $db_conn->query("DROP TABLE time_dimension");


    $time_dimension_table = "CREATE TABLE time_dimension (
        id                      INTEGER PRIMARY KEY,
        db_date                 DATE NOT NULL,
        year                    INTEGER NOT NULL,
        month                   INTEGER NOT NULL,
        day                     INTEGER NOT NULL,
        quarter                 INTEGER NOT NULL,
        week                    INTEGER NOT NULL,
        day_name                VARCHAR(9) NOT NULL,
        month_name              VARCHAR(9) NOT NULL,
        holiday_flag            CHAR(1) DEFAULT 'f' CHECK (holiday_flag in ('t', 'f')),
        weekend_flag            CHAR(1) DEFAULT 'f' CHECK (weekend_flag in ('t', 'f')),
        event                   VARCHAR(50),
        UNIQUE td_ymd_idx (year,month,day),
        UNIQUE td_dbdate_idx (db_date)
    )";

    if($db_conn->query($time_dimension_table)){
        echo '<div class="alert alert-success" role="alert">
            Time Dimension Table Created!!!
        </div>';
        // echo "Created User Table<br><hr>";
    }
    else{
        echo '<div class="alert alert-danger" role="alert">
            Time Dimension Table Creation Failed!!!
        </div>';
        // echo "Error While Creating User Table<br><hr>";
    }

    // // Booking Agent and Admin Table
    $user_table = "CREATE TABLE users(
        id INT NOT NULL AUTO_INCREMENT,
        email VARCHAR(255),
        name VARCHAR(20) NOT NULL,
        phone VARCHAR(15) NOT NULL,
        password CHAR(32) NOT NULL,
        isAdmin INT DEFAULT 0,
        PRIMARY KEY(email),
        INDEX(id)
    )";

    if($db_conn->query($user_table)){
        echo '<div class="alert alert-success" role="alert">
            User Table Created!!!
        </div>';
        // echo "Created User Table<br><hr>";
    }
    else{
        echo '<div class="alert alert-danger" role="alert">
            User Table Creation Failed!!!
        </div>';
        // echo "Error While Creating User Table<br><hr>";
    }

    $train_info = "CREATE TABLE train_info(
        train VARCHAR(5) NOT NULL,
        fstation VARCHAR(4) NOT NULL,
        tstation VARCHAR(4) NOT NULL,
        startTime TIME,
        endTime TIME,
        primary key (train)
    )";

    if($db_conn->query($train_info)){
        echo '<div class="alert alert-success" role="alert">
            Train Info Table Created!!!
        </div>';
        // echo "Created Train Table<br><hr>";
    }
    else{
        echo '<div class="alert alert-danger" role="alert">
            Train Info Table Creation Failed!!!
        </div>';
        // echo "Error While Creating Train Table<br><hr>";
    }

    // Train Information
    $train_table = "CREATE TABLE train(
        train VARCHAR(5) NOT NULL,
        date DATE NOT NULL,
        ac INT DEFAULT 0,
        sleeper INT DEFAULT 0,
        PRIMARY KEY(train, date),
        FOREIGN KEY (train) REFERENCES train_info(train),
        FOREIGN KEY (date) REFERENCES time_dimension(db_date)
    )";

    if($db_conn->query($train_table)){
        echo '<div class="alert alert-success" role="alert">
            Train Table Created!!!
        </div>';
        // echo "Created Train Table<br><hr>";
    }
    else{
        echo '<div class="alert alert-danger" role="alert">
            Train Table Creation Failed!!!
        </div>';
        // echo "Error While Creating Train Table<br><hr>";
    }

    $ticket_table = "CREATE TABLE ticket(
        pnr INT NOT NULL AUTO_INCREMENT,
        booked_by INT NOT NULL,
        train_number VARCHAR(5) NOT NULL,
        date DATE NOT NULL,
        coach_type CHAR(1) NOT NULL,
        num_passengers INT NOT NULL,
        booked_on DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(pnr),
        FOREIGN KEY (booked_by) REFERENCES users(id),
        FOREIGN KEY (train_number, date) REFERENCES train(train, date)
    )";

    if($db_conn->query($ticket_table)){
        echo '<div class="alert alert-success" role="alert">
            Ticket Table Created!!!
        </div>';
        // echo "Created Ticket Table<br><hr>";
    }
    else{
        echo '<div class="alert alert-danger" role="alert">
            Ticket Table Creation Failed!!!
        </div>';
        // echo "Error While Creating Ticket Table<br><hr>";
    }

    $passenger_table = "CREATE TABLE passenger(
        pnr INT NOT NULL,
        coach_number VARCHAR(10),
        seat_number INT,
        p_name VARCHAR(128) NOT NULL,
        p_age INT NOT NULL,
        p_gender CHAR(1) NOT NULL,
        seat_type CHAR(2) NOT NULL,
        PRIMARY KEY(pnr, coach_number, seat_number),
        FOREIGN KEY (pnr) REFERENCES ticket(pnr)
    )";

    if($db_conn->query($passenger_table)){
        echo '<div class="alert alert-success" role="alert">
            Passenger Table Created!!!
        </div>';
        // echo "Created Passenger Table<br><hr>";
    }
    else{
        echo '<div class="alert alert-danger" role="alert">
            Passenger Table Creation Failed!!!
        </div>';
        // echo "Error While Creating Passenger Table<br><hr>";
    }

    $sleeper_coach_table = "CREATE TABLE sleeper_coach(
        seat_number INT PRIMARY KEY,
        seat_type CHAR(2)
    )";

    if($db_conn->query($sleeper_coach_table)){
        echo '<div class="alert alert-success" role="alert">
            Sleeper Coach Table Created!!!
        </div>';
        // echo "Created Sleeper Coach Table<br><hr>";
    }
    else{
        echo '<div class="alert alert-danger" role="alert">
            Sleeper Coach Table Creation Failed!!!
        </div>';
        // echo "Error While Creating Sleeper Coach Table<br><hr>";
    }

    $ac_coach_table = "CREATE TABLE ac_coach(
        seat_number INT PRIMARY KEY,
        seat_type CHAR(2)
    )";

    if($db_conn->query($ac_coach_table)){
        echo '<div class="alert alert-success" role="alert">
            AC Coach Table Created!!!
        </div>';
        // echo "Created AC Coach Table<br><hr>";
    }
    else{
        echo '<div class="alert alert-danger" role="alert">
            AC Coach Table Creation Failed!!!
        </div>';
        // echo "Error While Creating AC Coach Table<br><hr>";
    }

    $admin_user = 'CALL createAdmin("admin", "admin@gmail.com", "1234567890", "root")';
    if($db_conn->query($admin_user)){
        echo '<div class="alert alert-success" role="alert">
            Admin User: e-mail => admin@gmail.com, password => root
        </div>';
    }

?>
</div>
