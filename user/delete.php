<?php 
include_once("../layouts/header.php");
include_once("../config/database.php");

$id = $_REQUEST['id'];
$query = 'DELETE FROM users WHERE id = ?';
$res   = $pdo->prepare($query);

if($res->execute([$id])){
    echo "<script>
            alert('User deleted successfully.');
            window.location.href = 'create.php';
          </script>";
} else {
    echo "<script>
            alert('Something went wrong ❌');
            window.location.href = 'create.php';
          </script>";
}
?>

<?php include_once("../layouts/footer.php");?>
