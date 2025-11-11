<?php include_once("../layouts/header.php") ?>
<?php include_once("../config/database.php") ?>

<div class="container mt-4">

<?php 
    $user_read_query = "SELECT id, username, password, phone, role FROM users ORDER BY id DESC";
    $readRes = $pdo->prepare($user_read_query);
    $readRes->execute();
    $users = $readRes->fetchAll(PDO::FETCH_ASSOC);

    echo '<h2 class="text-center mb-4 text-primary">User Information</h2>';
    echo "<table class='table table-bordered table-striped  align-middle' border-0>";
    echo "<thead class='table-white'>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Password</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
          </thead>";
    
    echo "<tbody>";

    foreach($users as $data){
        $userId   = $data['id'];
        $userName = $data['username'];
        $pass     = $data['password'];
        $phone    = $data['phone'];
        $role     = $data['role'];

        echo "<tr>
                <td>$userId</td>
                <td>$userName</td>
                <td>$pass</td>
                <td>$phone</td>
                <td>$role</td>
                <td>
                    <a href='./update.php?id=$userId' class='btn btn-primary btn-sm me-2'>Update</a>
                    <a href='./delete.php?id=$userId' class='btn btn-danger btn-sm'>Delete</a>
                </td>
              </tr>";
    }

    echo "</tbody>";
    echo "</table>";
?>
</div>
