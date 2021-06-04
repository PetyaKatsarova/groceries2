<?php
include_once 'dbconnection.php';

$to_sort_recipes = [];
$stmt = $db->query("SELECT recipe_id, recipe_name FROM recipes");
if($stmt->num_rows > 0){
    while($row=$stmt->fetch_assoc()){
        $to_sort_recipes[$row['recipe_id']] = $row['recipe_name'];
    }
}else{
    echo "Error in retrieving recipe_name or/and recipe_id";
}

asort($to_sort_recipes);

foreach($to_sort_recipes as $key=>$val){
?>
    <option value=<?php echo $key ?> ><?php echo $val ?></option>;
<?php
}
?>

