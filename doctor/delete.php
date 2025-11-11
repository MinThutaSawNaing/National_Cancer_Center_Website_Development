<?php 
include_once("../layouts/header.php");
include_once("../config/database.php");

$id = $_REQUEST['doctor_id'];
$query = 'DELETE FROM doctors WHERE doctor_id = ?';
$res   = $pdo->prepare($query);

if($res->execute([$id])){
    echo "<script>
            alert('Doctor deleted successfully ✅');
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
