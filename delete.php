<?php
$id = $_GET['id'];

$db = mysqli_connect('localhost', 'root', '', 'psread');

$query = "DELETE FROM message WHERE id = $id"; 
mysqli_query($db, $query);

header('Location: admin.php');
?>