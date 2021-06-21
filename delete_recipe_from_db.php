<?php
include_once 'dbconnection.php';

$option = isset($_POST['delete_recipe_name']) ? $_POST['delete_recipe_name'] : false;

if($option){
    $id = $_POST['delete_recipe_name'];
    $sql = "DELETE from recipes WHERE recipe_id = ?";
    $stmt5 = $db->prepare($sql);
    $stmt5->bind_param('i', $id);

    if ($stmt5->execute() === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $db->error;
    }
    // $db->close();
} 