<?php 

    try{

        $pdo = new PDO("mysql:hostname=localhost;dbname=hospital_db","root","");
        // echo "db connection success!" ;

    }catch(PDOException $err){
        echo "db connection fail! .$err";
    };

?>