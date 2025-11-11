<?php
session_start();
include_once("../layouts/header.php");
include_once("../config/database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <style>
        .card-title {
          color: #262626;
          font-size: 1.5em;
          line-height: normal;
          font-weight: 700;
          margin-bottom: 0.5em;
        }

        .small-desc {
          font-size: 1em;
          font-weight: 400;
          line-height: 1.5em;
          color: #452c2c;
        }

        .small-desc {
          font-size: 1em;
        }

        .go-corner {
          display: flex;
          align-items: center;
          justify-content: center;
          position: absolute;
          width: 2em;
          height: 2em;
          overflow: hidden;
          top: 0;
          right: 0;
          background: linear-gradient(135deg, #6293c8, #e1e4ebff);
          border-radius: 0 4px 0 32px;
        }

        .go-arrow {
          margin-top: -4px;
          margin-right: -4px;
          color: white;
          font-family: courier, sans;
        }

        .card {
          display: block;
          position: relative;
          max-width: 300px;
          max-height: 320px;
          background-color: #f2f8f9;
          border-radius: 10px;
          padding: 2em 1.2em;
          margin: 12px;
          text-decoration: none;
          z-index: 0;
          overflow: hidden;
          background: linear-gradient(to bottom, #c3e6ec, #fafdfdff);
          font-family: Arial, Helvetica, sans-serif;
        }

        .card:before {
          content: '';
          position: absolute;
          z-index: -1;
          top: -16px;
          right: -16px;
          background: linear-gradient(135deg, #1780f0ff, #1665e6ff);
          height: 32px;
          width: 32px;
          border-radius: 32px;
          transform: scale(1);
          transform-origin: 50% 50%;
          transition: transform 0.35s ease-out;
        }

        .card:hover:before {
          transform: scale(28);
        }

        .card:hover .small-desc {
          transition: all 0.5s ease-out;
          color: rgba(255, 255, 255, 0.8);
        }

        .card:hover .card-title {
          transition: all 0.5s ease-out;
          color: #ffffff;
}

    </style>
</head>
<body>
<div class="container mt-2">
    <div class="row">
        <div class="col-md-4">
                <div class="card">
                  <i class="fa-solid fa-user-doctor"></i>
                    <p class="card-title">Doctors</p>
                  
                    
                    <p class="small-desc">
                    <a href="../doctor/doctorlist.php" class="btn btn-primary">View Details 
                                        <span class="badge">
                                        <?php
                                        $query="Select * from doctors";
                                        $doctor_query= $pdo->prepare($query);
                                        $doctor_query->execute();

                                        $result = $doctor_query->fetchAll(PDO::FETCH_ASSOC);

                                        // echo "<pre>";
                                        // print_r($result);
                                        ?>
                                        </span>
                                        </a>
                    </p>
        </div>
        <div class="col-md-6 mx-4">
          <form class="form" method="post">
            <input type="submit" value="Add Doctor" class="btn btn-primary btn-rounded btn-sm" name="btn_add">
          </form>
        </div>

          <?php if(isset($_POST['btn_add'])){
            echo "<script> window.location.href='../doctor/create.php';</script>";
          } ?>
    </div><br>

    <div class="row">
        <div class="col-md-4">
                <div class="card">
                    <p class="card-title">Patients</p>
                    <p class="small-desc">
                    <a href="#" class="btn btn-primary">View Details 
                                        <span class="badge">
                                        <?php
                                        $query="Select * from patients";
                                        $get_query= $pdo->prepare($query);
                                        $get_query->execute();

                                        $result = $get_query->fetchAll(PDO::FETCH_ASSOC);
                                        ?>
                                        </span>
                                        </a>
                    </p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-md-4">
                <div class="card">
                    <p class="card-title">Users</p>
                    <p class="small-desc">
                    <a href="../user/userlist.php" class="btn btn-primary">View Details 
                                        <span class="badge">
                                        <?php
                                        $query="Select * from users";
                                        $get_query= $pdo->prepare($query);
                                        $get_query->execute();

                                        $result = $get_query->fetchAll(PDO::FETCH_ASSOC);
                                        ?>
                                        </span>
                                        </a>
                    </p>
        </div>
    </div><br>
</div>
</body>
</html>  
