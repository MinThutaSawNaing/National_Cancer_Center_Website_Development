<?php include_once("../layouts/header.php"); ?>
<?php include_once("../config/database.php"); ?>

<div class="container my-5">
    <?php
    //  Fetch doctors with their schedules
    $sql = "SELECT d.doctor_id, d.full_name, d.specialization, d.phone, d.email,
                   s.duty_day, s.duty_start, s.duty_end
            FROM doctors d
            LEFT JOIN doctor_schedules s ON d.doctor_id = s.doctor_id
            ORDER BY d.full_name, 
                     FIELD(s.duty_day,'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //  Group schedules by doctor
    $doctors = [];
    foreach ($rows as $row) {
        $id = $row['doctor_id'];
        if (!isset($doctors[$id])) {
            $doctors[$id] = [
                'id' => $row['doctor_id'],
                'full_name' => $row['full_name'],
                'specialization' => $row['specialization'],
                'phone' => $row['phone'],
                'email' => $row['email'],
                'schedules' => []
            ];
        }
        if ($row['duty_day']) {
            $doctors[$id]['schedules'][] = $row['duty_day'] . ' (' . $row['duty_start'] . ' - ' . $row['duty_end'] . ')';
        }
    }

    // 3️⃣ Display doctors table
    if (count($doctors) > 0) {
        echo '<h2 class="text-center mb-4 text-primary">Doctor Information</h2>';
        echo '<div class="table-responsive">';
        echo '<table class="table table-bordered table-striped table-hover shadow-sm">';
        echo '<thead class="bg-primary text-white">';
        echo '<tr>';
        echo '<th>No</th>';
        echo '<th>Name</th>';
        echo '<th>Specialization</th>';
        echo '<th>Phone</th>';
        echo '<th>Email</th>';
        echo '<th>Schedules</th>';
        echo '<th>Actions</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($doctors as $id => $doc) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($doc['id']). '</td>';
            echo '<td>' . htmlspecialchars($doc['full_name']) . '</td>';
            echo '<td>' . htmlspecialchars($doc['specialization']) . '</td>';
            echo '<td>' . htmlspecialchars($doc['phone']) . '</td>';
            echo '<td>' . htmlspecialchars($doc['email']) . '</td>';

            // Show schedules
            $scheduleStr = count($doc['schedules']) ? implode('<br>', $doc['schedules']) : 'No schedule';
            echo '<td>' . $scheduleStr . '</td>';

            // Actions
            echo '<td>';
            echo "<a href='update.php?doctor_id=$id' class='btn btn-primary btn-sm me-2'>Update</a>";
            echo "<a href='delete.php?doctor_id=$id' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure?')\">Delete</a>";
            echo '</td>';

            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>'; // table-responsive
    } else {
        echo '<p class="text-center text-danger">No doctors found in the database.</p>';
    }
    ?>
</div>

<?php include_once("../layouts/footer.php"); ?>
