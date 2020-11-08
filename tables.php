<?php

    // Booking Agent and Admin Table
    $user_table = "CREATE TABLE user(
        email VARCHAR(255) PRIMARY_KEY,
        name VARCHAR(20) NOT NULL,
        phone VARCHAR(15) NOT NULL,
        password CHAR(32) NOT NULL,
        isAdmin INT DEFAULT 0
    )";

    // Train Information
    $train_table = "CREATE TABLE train(
        train VARCHAR(5) NOT NULL,
        date DATE NOT NULL,
        ac INT DEFAULT 0,
        sleeper INT DEFAULT 0,
        PRIMARY_KEY(train, date)
    )";

    

?>