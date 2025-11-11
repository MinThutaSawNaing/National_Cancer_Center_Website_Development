<?php include_once("../layouts/header.php");?>
<?php include_once("../config/database.php");?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-6 ">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post">
                        <input type="text" class="form-control my-3" placeholder="Enter Doctor Name..." name="doctorName">
                        <?php
                        if(isset($_POST['btn-create'])){
                            $doctorStatus = $_POST['doctorName'] != "";
                            echo $doctorStatus ? "" : "<small class='text-danger mb-2'>Name is required!</small>";
                        }
                        ?>

                        <input type="text" class="form-control my-3" placeholder="Enter specialization..." name="specialization">
                        <?php
                        if(isset($_POST['btn-create'])){
                            $doctorStatus = $_POST['specialization'] != "";
                            echo $doctorStatus ? "" : "<small class='text-danger mb-2'>Specialization is required!</small>";
                        }
                        ?>

                        <input type="text" class="form-control my-3" placeholder="Enter phone..." name="phone">
                        <?php
                        if(isset($_POST['btn-create'])){
                            $doctorStatus = $_POST['phone'] != "";
                            echo $doctorStatus ? "" : "<small class='text-danger mb-2'>Phone number is required!</small>";
                        }
                        ?>

                        <input type="text" class="form-control my-3" placeholder="Enter email..." name="email">
                        <?php
                        if(isset($_POST['btn-create'])){
                            $doctorStatus = $_POST['email'] != "";
                            echo $doctorStatus ? "" : "<small class='text-danger mb-2'>Email is required!</small>";
                        }
                        ?>

                        <!-- <label>Duty Start:</label>
                        <input type="time" name="duty_start" class="form-control my-3">
                        <label>Duty End:</label>
                        <input type="time" name="duty_end" class="form-control my-2"> -->

                        <h5 class="mt-3">Duty Days & Times</h5>
                        <?php
                            $days = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
                            foreach($days as $day){
                                $checked = isset($_POST['duty_day'][$day]) ? "checked" : "";
                                $start_val = $_POST['duty_start'][$day] ?? "";
                                $end_val   = $_POST['duty_end'][$day] ?? "";
                                
                                echo '<div class="mb-3">';
                                echo '<label><input type="checkbox" name="duty_day['.$day.']" value="1" '.$checked.'> '.$day.'</label><br><br>';

                                echo 'Start: <input type="time" name="duty_start['.$day.']" value="'.$start_val.'">';
                                echo ' End: <input type="time" name="duty_end['.$day.']" value="'.$end_val.'">';
                                echo '</div>';
                            }
                        ?>



                        <input type="submit" value="Add Doctor" class="w-100 btn btn-primary rounded shadow-sm mt-2" name="btn-create">
                    </form>
                </div>
            </div>

            <?php
            if(isset($_POST['btn-create'])){
    $doctorName  = $_POST['doctorName'];
    $doctorSpec  = $_POST['specialization'];
    $phone       = $_POST['phone'];
    $email       = $_POST['email'];
    $dutyDays    = $_POST['duty_day'] ?? [];
    $dutyStart   = $_POST['duty_start'] ?? [];
    $dutyEnd     = $_POST['duty_end'] ?? [];

    // Basic validation
    if($doctorName && $doctorSpec && $phone && $email && count($dutyDays) > 0){

        // 1️⃣ Insert doctor
        $stmt = $pdo->prepare("INSERT INTO doctors(full_name,specialization,phone,email) VALUES (?,?,?,?)");
        $stmt->execute([$doctorName,$doctorSpec,$phone,$email]);
        $doctor_id = $pdo->lastInsertId();

        // 2️⃣ Insert each day’s schedule
        $stmtInsert = $pdo->prepare("INSERT INTO doctor_schedules(doctor_id,duty_day,duty_start,duty_end) VALUES (?,?,?,?)");
        $stmtCheck  = $pdo->prepare("SELECT * FROM doctor_schedules 
                                     WHERE doctor_id=? AND duty_day=? 
                                     AND ((duty_start <= ? AND duty_end > ?) OR (duty_start < ? AND duty_end >= ?))");

        $conflict = false;
        foreach($dutyDays as $day => $val){
            $start = $dutyStart[$day];
            $end   = $dutyEnd[$day];

            // check overlap
            $stmtCheck->execute([$doctor_id,$day,$start,$start,$end,$end]);
            if($stmtCheck->rowCount() > 0){
                $conflict = true;
                echo "<small class='text-danger'>⚠️ Conflict on $day!</small><br>";
            } else {
                $stmtInsert->execute([$doctor_id,$day,$start,$end]);
            }
        }

        if(!$conflict){
            echo "<script>alert('Doctor added successfully ✅'); window.location.href='doctorlist.php';</script>";
        }

    } else {
        echo "<small class='text-danger'>Please fill all fields and select at least one day!</small>";
    }
}

            ?>

        </div>
    </div>
</div>

<?php include_once("../layouts/footer.php")?>
