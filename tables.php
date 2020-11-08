<?php
    $user = 'root';
    $pass = '';
    $db = 'dbms_pro';
    $db_conn = new mysqli('localhost', $user, $pass, $db) or die("Unable To Connect");
    
    $db_conn->query("DROP TABLE users");
    $db_conn->query("DROP TABLE train");
    $db_conn->query("DROP TABLE ticket");
    $db_conn->query("DROP TABLE passenger");
    $db_conn->query("DROP TABLE ac_coach");
    $db_conn->query("DROP TABLE sleeper_coach");

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
        echo "Created User Table<br><hr>";
    }
    else{
        echo "Error While Creating User Table<br><hr>";
    }

    // Train Information
    $train_table = "CREATE TABLE train(
        train VARCHAR(5) NOT NULL,
        date DATE NOT NULL,
        ac INT DEFAULT 0,
        sleeper INT DEFAULT 0,
        PRIMARY KEY(train, date)
    )";

    if($db_conn->query($train_table)){
        echo "Created Train Table<br><hr>";
    }
    else{
        echo "Error While Creating Train Table<br><hr>";
    }

    $ticket_table = "CREATE TABLE ticket(
        pnr VARCHAR(10),
        booked_by INT NOT NULL REFERENCES users(id),
        train_number VARCHAR(5) NOT NULL REFERENCES train(train),
        date DATE NOT NULL REFERENCES train(date),
        coach_type CHAR(1) NOT NULL,
        num_passengers INT NOT NULL,
        PRIMARY KEY(pnr)
    )";

    if($db_conn->query($ticket_table)){
        echo "Created Ticket Table<br><hr>";
    }
    else{
        echo "Error While Creating Ticket Table<br><hr>";
    }

    $passenger_table = "CREATE TABLE passenger(
        pnr VARCHAR(10) NOT NULL REFERENCES ticket(pnr),
        coach_number VARCHAR(10),
        seat_number INT,
        p_name VARCHAR(128) NOT NULL,
        p_age INT NOT NULL,
        p_gender CHAR(1) NOT NULL,
        seat_type CHAR(2) NOT NULL,
        PRIMARY KEY(pnr, coach_number, seat_number)
    )";

    if($db_conn->query($passenger_table)){
        echo "Created Passenger Table<br><hr>";
    }
    else{
        echo "Error While Creating Passenger Table<br><hr>";
    }

    $sleeper_coach_table = "CREATE TABLE sleeper_coach(
        seat_number INT PRIMARY KEY,
        seat_type CHAR(2)
    )";

    if($db_conn->query($sleeper_coach_table)){
        echo "Created Sleeper Coach Table<br><hr>";
    }
    else{
        echo "Error While Creating Sleeper Coach Table<br><hr>";
    }

    $ac_coach_table = "CREATE TABLE ac_coach(
        seat_number INT PRIMARY KEY,
        seat_type CHAR(2)
    )";

    if($db_conn->query($ac_coach_table)){
        echo "Created AC Coach Table<br><hr>";
    }
    else{
        echo "Error While Creating AC Coach Table<br><hr>";
    }

?>