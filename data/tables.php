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
    
    
    $db_conn->query("DROP TABLE passenger");
    $db_conn->query("DROP TABLE ticket");
    $db_conn->query("DROP TABLE train");
    $db_conn->query("DROP TABLE train_info");
    $db_conn->query("DROP TABLE users");
    $db_conn->query("DROP TABLE ac_coach");
    $db_conn->query("DROP TABLE sleeper_coach");
    $db_conn->query("DROP TABLE time_dimension");


    // Table Creation Started

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
        date_id INTEGER NOT NULL,
        ac INT DEFAULT 0,
        sleeper INT DEFAULT 0,
        PRIMARY KEY(train, date_id),
        FOREIGN KEY (train) REFERENCES train_info(train),
        FOREIGN KEY (date_id) REFERENCES time_dimension(id)
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
        date_id INTEGER NOT NULL,
        coach_type CHAR(1) NOT NULL,
        num_passengers INT NOT NULL,
        PRIMARY KEY(pnr),
        FOREIGN KEY (booked_by) REFERENCES users(id),
        FOREIGN KEY (train_number, date_id) REFERENCES train(train, date_id)
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

    // Table Creation Completed

    // Procedures

    $fill_date_procedure = "
    DELIMITER //
    CREATE PROCEDURE fill_date_dimension(IN startdate DATE,IN stopdate DATE)
    BEGIN
        DECLARE currentdate DATE;
        SET currentdate = startdate;
        WHILE currentdate < stopdate DO
            INSERT INTO time_dimension VALUES (
                            YEAR(currentdate)*10000+MONTH(currentdate)*100 + DAY(currentdate),
                            currentdate,
                            YEAR(currentdate),
                            MONTH(currentdate),
                            DAY(currentdate),
                            QUARTER(currentdate),
                            WEEKOFYEAR(currentdate),
                            DATE_FORMAT(currentdate,'%W'),
                            DATE_FORMAT(currentdate,'%M'),
                            'f',
                            CASE DAYOFWEEK(currentdate) WHEN 1 THEN 't' WHEN 7 then 't' ELSE 'f' END,
                            NULL);
            SET currentdate = ADDDATE(currentdate,INTERVAL 1 DAY);
        END WHILE;
    END
    //
    DELIMITER ;
    ";

    $insertPassenger_procedure = "
        DELIMITER $$

    CREATE PROCEDURE insertPassenger(
        IN pnr INT,
        IN coach_type CHAR(1),
        IN p_name VARCHAR(128),
        IN p_age INT,
        IN p_gender CHAR(1)
    )
    BEGIN
        DECLARE max_allocated INT DEFAULT 0;
        DECLARE train_no_var VARCHAR(5);
        DECLARE date_var INTEGER;
        DECLARE seat_number INT DEFAULT 0;
        DECLARE coach_number INT DEFAULT 0;
        DECLARE seat_type_var CHAR(2);

        SELECT ticket.train_number, ticket.date_id
        INTO train_no_var, date_var
        FROM ticket
        WHERE ticket.pnr=pnr;

        SELECT COUNT(*)
        INTO max_allocated
        FROM ticket as T, passenger as P
        WHERE T.pnr=P.pnr AND T.train_number=train_no_var 
                AND T.date_id=date_var AND T.coach_type=coach_type;

        IF coach_type='A' THEN
            SET coach_number = FLOOR(max_allocated/18) + 1;
            SET seat_number = (max_allocated%18) + 1;
            SELECT A.seat_type
            INTO seat_type_var
            FROM ac_coach as A
            WHERE A.seat_number=seat_number;
        END IF;
        IF coach_type='S' THEN
            SET coach_number = FLOOR(max_allocated/24) + 1;
            SET seat_number = (max_allocated%24) + 1;
            SELECT S.seat_type
            INTO seat_type_var
            FROM sleeper_coach as S
            WHERE S.seat_number=seat_number;
        END IF;

        INSERT INTO passenger VALUES (pnr, coach_number, seat_number, p_name, p_age, p_gender, seat_type_var);

    END
    $$
        ";

    $insertTicket_trigger = "
    delimiter //
    CREATE TRIGGER `insert_ticket` BEFORE INSERT ON `ticket`
     FOR EACH ROW BEGIN
        
        declare max_allocated INT DEFAULT 0;
        declare max_seats INT default 0;
        declare tt int default 0;
        select count(*) into tt from train where train.train=new.train_number and train.date=new.date;
        if tt=0 then 
            signal sqlstate '45000' set MESSAGE_TEXT='No such train exists';
           end if;
        select sum(num_passengers) into max_allocated from ticket t where t.train_number=new.train_number and t.date=new.date and t.coach_type=new.coach_type ;
        if max_allocated is null then set max_allocated = 0;
        end if;
        if new.coach_type='A' THEN
            select ac into max_seats from train where train.train=new.train_number and train.date=new.date;
            set max_seats = max_seats* 18;
        ELSE
            select sleeper into max_seats from train where train.train=new.train_number and train.date= new.date;
            set max_seats= max_seats * 24;
        end if;
        if max_allocated + new.num_passengers > max_seats THEN
            signal SQLSTATE '45000' SET  MESSAGE_TEXT='Not enough seats';
        end if;
    end //
    
    delimiter ;
    ";

    if($db_conn->query($fill_date_procedure)){
        echo '<div class="alert alert-success" role="alert">
           Fill Date Procedure Created!!!
        </div>';
    }
    else{
        echo '<div class="alert alert-success" role="alert">
            Fill Date Creation Failed!!!
        </div>';
    }

    if($db_conn->query($insertPassenger_procedure)){
        echo '<div class="alert alert-success" role="alert">
        insertPassenger Procedure Created!!!
        </div>';
    }
    else{
        echo '<div class="alert alert-success" role="alert">
        insertPassenger Creation Failed!!!
        </div>';
    }

    if($db_conn->query($insertTicket_trigger)){
        echo '<div class="alert alert-success" role="alert">
        insertTicket_trigger Created!!!
        </div>';
    }
    else{
        echo '<div class="alert alert-success" role="alert">
        insertTicket_trigger Creation Failed!!!
        </div>';
    }

    $populate_time_dimension = "CALL fill_date_dimension('2020-01-01','2022-01-01')";

    if($db_conn->query($populate_time_dimension)){
        echo '<div class="alert alert-success" role="alert">
            Time Dimension Populated
        </div>';
    }

    $admin_user = 'CALL createAdmin("admin", "admin@gmail.com", "1234567890", "root")';
    if($db_conn->query($admin_user)){
        echo '<div class="alert alert-success" role="alert">
            Admin User: e-mail => admin@gmail.com, password => root
        </div>';
    }

    $ac_pop = "/* INSERT QUERY NO: 1 */
    INSERT INTO ac_coach(seat_number, seat_type)
    VALUES
    (
    1, 'LB'
    );
    
    /* INSERT QUERY NO: 2 */
    INSERT INTO ac_coach(seat_number, seat_type)
    VALUES
    (
    2, 'LB'
    );
    
    /* INSERT QUERY NO: 3 */
    INSERT INTO ac_coach(seat_number, seat_type)
    VALUES
    (
    3, 'UB'
    );
    
    /* INSERT QUERY NO: 4 */
    INSERT INTO ac_coach(seat_number, seat_type)
    VALUES
    (
    4, 'UB'
    );
    
    /* INSERT QUERY NO: 5 */
    INSERT INTO ac_coach(seat_number, seat_type)
    VALUES
    (
    5, 'SL'
    );
    
    /* INSERT QUERY NO: 6 */
    INSERT INTO ac_coach(seat_number, seat_type)
    VALUES
    (
    6, 'SU'
    );
    
    /* INSERT QUERY NO: 7 */
    INSERT INTO ac_coach(seat_number, seat_type)
    VALUES
    (
    7, 'LB'
    );
    
    /* INSERT QUERY NO: 8 */
    INSERT INTO ac_coach(seat_number, seat_type)
    VALUES
    (
    8, 'LB'
    );
    
    /* INSERT QUERY NO: 9 */
    INSERT INTO ac_coach(seat_number, seat_type)
    VALUES
    (
    9, 'UB'
    );
    
    /* INSERT QUERY NO: 10 */
    INSERT INTO ac_coach(seat_number, seat_type)
    VALUES
    (
    10, 'UB'
    );
    
    /* INSERT QUERY NO: 11 */
    INSERT INTO ac_coach(seat_number, seat_type)
    VALUES
    (
    11, 'SL'
    );
    
    /* INSERT QUERY NO: 12 */
    INSERT INTO ac_coach(seat_number, seat_type)
    VALUES
    (
    12, 'SU'
    );
    
    /* INSERT QUERY NO: 13 */
    INSERT INTO ac_coach(seat_number, seat_type)
    VALUES
    (
    13, 'LB'
    );
    
    /* INSERT QUERY NO: 14 */
    INSERT INTO ac_coach(seat_number, seat_type)
    VALUES
    (
    14, 'LB'
    );
    
    /* INSERT QUERY NO: 15 */
    INSERT INTO ac_coach(seat_number, seat_type)
    VALUES
    (
    15, 'UB'
    );
    
    /* INSERT QUERY NO: 16 */
    INSERT INTO ac_coach(seat_number, seat_type)
    VALUES
    (
    16, 'UB'
    );
    
    /* INSERT QUERY NO: 17 */
    INSERT INTO ac_coach(seat_number, seat_type)
    VALUES
    (
    17, 'SL'
    );
    
    /* INSERT QUERY NO: 18 */
    INSERT INTO ac_coach(seat_number, seat_type)
    VALUES
    (
    18, 'SU'
    );
    
    ";
    $sl_pop = "
    /* INSERT QUERY NO: 1 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    1, 'LB'
    );
    
    /* INSERT QUERY NO: 2 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    2, 'MB'
    );
    
    /* INSERT QUERY NO: 3 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    3, 'UB'
    );
    
    /* INSERT QUERY NO: 4 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    4, 'LB'
    );
    
    /* INSERT QUERY NO: 5 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    5, 'MB'
    );
    
    /* INSERT QUERY NO: 6 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    6, 'UB'
    );
    
    /* INSERT QUERY NO: 7 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    7, 'SL'
    );
    
    /* INSERT QUERY NO: 8 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    8, 'SU'
    );
    
    /* INSERT QUERY NO: 9 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    9, 'LB'
    );
    
    /* INSERT QUERY NO: 10 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    10, 'MB'
    );
    
    /* INSERT QUERY NO: 11 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    11, 'UB'
    );
    
    /* INSERT QUERY NO: 12 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    12, 'LB'
    );
    
    /* INSERT QUERY NO: 13 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    13, 'MB'
    );
    
    /* INSERT QUERY NO: 14 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    14, 'UB'
    );
    
    /* INSERT QUERY NO: 15 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    15, 'SL'
    );
    
    /* INSERT QUERY NO: 16 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    16, 'SU'
    );
    
    /* INSERT QUERY NO: 17 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    17, 'LB'
    );
    
    /* INSERT QUERY NO: 18 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    18, 'MB'
    );
    
    /* INSERT QUERY NO: 19 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    19, 'UB'
    );
    
    /* INSERT QUERY NO: 20 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    20, 'LB'
    );
    
    /* INSERT QUERY NO: 21 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    21, 'MB'
    );
    
    /* INSERT QUERY NO: 22 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    22, 'UB'
    );
    
    /* INSERT QUERY NO: 23 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    23, 'SL'
    );
    
    /* INSERT QUERY NO: 24 */
    INSERT INTO sleeper_coach(seat_number, seat_type)
    VALUES
    (
    24, 'SU'
    );
    
    
    ";


    if($db_conn->query($ac_pop)){
        echo '<div class="alert alert-success" role="alert">
            AC Table Populated!!!
        </div>';
        // echo "Created AC Coach Table<br><hr>";
    }
    else{
        echo '<div class="alert alert-danger" role="alert">
        AC Table Not Populated!!!
        </div>';
        // echo "Error While Creating AC Coach Table<br><hr>";
    }

    if($db_conn->query($sl_pop)){
        echo '<div class="alert alert-success" role="alert">
            Sleeper Table Populated!!!
        </div>';
        // echo "Created AC Coach Table<br><hr>";
    }
    else{
        echo '<div class="alert alert-danger" role="alert">
        Sleeper Table Not Populated!!!
        </div>';
        // echo "Error While Creating AC Coach Table<br><hr>";
    }
?>
</div>
