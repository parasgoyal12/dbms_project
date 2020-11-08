<?php
    $user = 'root';
    $pass = '';
    $db = 'test';
    $db_conn = new mysqli('localhost', $user, $pass, $db) or die("Unable To Connect");
    
    // Booking Agent and Admin Table
    $user_table = "CREATE TABLE users(
        email VARCHAR(255),
        name VARCHAR(20) NOT NULL,
        phone VARCHAR(15) NOT NULL,
        password CHAR(32) NOT NULL,
        isAdmin INT DEFAULT 0,
        PRIMARY KEY(email)
    )";

    if($db_conn->query($user_table)){
        echo "Created User Table";
    }
    else{
        echo "Error While Creating User Table";
    }

    // Train Information
    // $train_table = "CREATE TABLE train(
    //     train VARCHAR(5) NOT NULL,
    //     date DATE NOT NULL,
    //     ac INT DEFAULT 0,
    //     sleeper INT DEFAULT 0,
    //     PRIMARY_KEY(train, date)
    // )";
?>