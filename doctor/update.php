<?php include_once("../layouts/header.php"); ?>
<?php include_once("../config/database.php"); ?>

<?php
if(!isset($_GET['doctor_id'])){
    echo "<script>alert('Invalid request ❌'); window.location.href='doctorlist.php';</script>";
    exit;
}

$doctor_id = $_GET['doctor_id'];

// Fetch doctor info
$stmt = $pdo->prepare("SELECT * FROM doctors WHERE doctor_id = ?");
$stmt->execute([$doctor_id]);
$doctor = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$doctor){
    echo "<script>alert('Doctor not found ❌'); window.location.href='doctorlist.php';</script>";
    exit;
}

// Fetch existing schedules
$stmt = $pdo->prepare("SELECT duty_day, duty_start, duty_end FROM doctor_schedules WHERE doctor_id = ?");
$stmt->execute([$doctor_id]);
$schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Convert schedules to associative array for easy access
$existingSchedules = [];
foreach($schedules as $sch){
    $existingSchedules[$sch['duty_day']] = [
        'start' => $sch['duty_start'],
        'end'   => $sch['duty_end']
    ];
}

// Days of week
$days = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-10 col-md-10 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post">
                        <!-- Doctor Info -->
                        <input type="text" name="doctorName" class="form-control my-2" placeholder="Enter Doctor Name..." 
                            value="<?php echo $_POST['doctorName'] ?? $doctor['full_name']; ?>" required>

                        <input type="text" class="form-control my-2" placeholder="Enter specialization..." name="specialization"
                            value="<?php echo $_POST['specialization'] ?? $doctor['specialization']; ?>" required>

                        <input type="text" class="form-control my-2" placeholder="Enter phone..." name="phone" 
                            value="<?php echo $_POST['phone'] ?? $doctor['phone']; ?>" required>
                            
                        <input type="text" class="form-control my-2" placeholder="Enter email..." name="email"
                            value="<?php echo $_POST['email'] ?? $doctor['email']; ?>" required>

                        <h5 class="mt-3">Duty Days & Times</h5>
                        <div class="container">
                            <?php
                            echo '<div class="row fw-bold mb-2">';
                            echo '<div class="col-4">Day</div>';
                            echo '<div class="col-4">Start Time</div>';
                            echo '<div class="col-4">End Time</div>';
                            echo '</div>';

                            foreach($days as $day){
                                $checked   = isset($existingSchedules[$day]) ? "checked" : "";
                                $start_val = $_POST['duty_start'][$day] ?? ($existingSchedules[$day]['start'] ?? '');
                                $end_val   = $_POST['duty_end'][$day] ?? ($existingSchedules[$day]['end'] ?? '');

                                echo '<div class="row mb-2 align-items-center">';
                                echo '<div class="col-4">';
                                echo '<label><input type="checkbox" name="duty_day['.$day.']" value="1" '.$checked.'> '.$day.'</label>';
                                echo '</div>';
                                echo '<div class="col-4">';
                                echo '<input type="time" class="form-control" name="duty_start['.$day.']" value="'.$start_val.'">';
                                echo '</div>';
                                echo '<div class="col-4">';
                                echo '<input type="time" class="form-control" name="duty_end['.$day.']" value="'.$end_val.'">';
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                        </div>

                        <input type="submit" value="Update Doctor" class="w-100 btn btn-primary rounded shadow-sm mt-3" name="btn-update">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_POST['btn-update'])){
    $doctorName  = $_POST['doctorName'];
    $doctorSpec  = $_POST['specialization'];
    $phone       = $_POST['phone'];
    $email       = $_POST['email'];
    $dutyDays    = $_POST['duty_day'] ?? [];
    $dutyStart   = $_POST['duty_start'] ?? [];
    $dutyEnd     = $_POST['duty_end'] ?? [];

    if($doctorName && $doctorSpec && $phone && $email){

        // 1️⃣ Update doctor info
        $stmt = $pdo->prepare("UPDATE doctors SET full_name=?, specialization=?, phone=?, email=? WHERE doctor_id=?");
        $stmt->execute([$doctorName, $doctorSpec, $phone, $email, $doctor_id]);

        // 2️⃣ Delete old schedules
        $pdo->prepare("DELETE FROM doctor_schedules WHERE doctor_id=?")->execute([$doctor_id]);

        // 3️⃣ Insert new schedules
        $stmtInsert = $pdo->prepare("INSERT INTO doctor_schedules (doctor_id,duty_day,duty_start,duty_end) VALUES (?,?,?,?)");

        $inserted = false;
        foreach($days as $day){
            $checked = isset($dutyDays[$day]);
            $start   = $dutyStart[$day] ?? '';
            $end     = $dutyEnd[$day] ?? '';

            if($checked && $start && $end){
                $stmtInsert->execute([$doctor_id, $day, $start, $end]);
                $inserted = true;
            }
        }

        if($inserted){
            echo "<script>alert('Doctor Updated Successfully ✅'); window.location.href='doctorlist.php';</script>";
        } else {
            echo "<small class='text-danger'>Please select at least one day with start and end time!</small>";
        }

    } else {
        echo "<small class='text-danger'>Please fill all fields!</small>";
    }
}
?>

<?php include_once("../layouts/footer.php"); ?>
