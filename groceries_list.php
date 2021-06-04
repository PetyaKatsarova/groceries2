<?php

// select from link recipe_id, ingr_id, quant, measur, and link/join to recipes and ingr tables to get names
include_once 'dbconnection.php';

if(isset($_POST['submit_groceries_list'])){

    $recipe_id = $_POST['recipe_id']; 
    $num = $_POST['number_pple'];

    $stmt = $db->query("SELECT link.ingredient_id, link.recipe_id, link.quantity, link.measurement, recipes.recipe_name, recipes.instructions, ingredients.ingredient_name FROM link LEFT JOIN ingredients ON link.ingredient_id=ingredients.ingredient_id LEFT JOIN recipes ON link.recipe_id=recipes.recipe_id WHERE link.recipe_id='". $recipe_id ."' ");
   

    $recipe_name = 'Did you add ingredients and quantity to the recipe? ';
    $info = "<ul>";
    if($stmt->num_rows > 0){
        while($row=$stmt->fetch_assoc()){
            $m = '';
            if($row['measurement'] !== ''){
                $m = $row['measurement'];
            }
            $recipe_name = $row['recipe_name'];
            $info .= "<li>" . $row['ingredient_name'] . ": " . $row['quantity'] . " " . $m . "</li>";
        }
    }
    $info .= "</ul>";
} 

?>
<h3><?php echo ucfirst($recipe_name) . " for $num"; ?></h3>
<?php echo $info; ?>