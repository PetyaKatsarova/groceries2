<script>
  document.getElementById('delete_recipe_name').addEventListener('click', ()=>{
      ('Are you sure you want to delete this recipe?');
  });
</script>

<?php
include_once 'dbconnection.php';

$option = isset($_POST['delete_recipe_name']) ? $_POST['delete_recipe_name'] : false;

if($option){
    $id = $_POST['delete_recipe_name'];
    $sql = "DELETE from recipes WHERE recipe_id = '". $id ."'";
    if ($db->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $db->error;
    }
    // $db->close();
} 