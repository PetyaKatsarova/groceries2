<?php

// select from link recipe_id, ingr_id, quant, measur, and link/join to recipes and ingr tables to get names
include_once 'dbconnection.php';

if(isset($_POST['submit_groceries_list'])){

    $recipe_id = $_POST['recipe_id']; 
    $num = $_POST['number_pple'];
    $instructions = '';
    $cook_time = 0;

    $stmt = $db->prepare("SELECT link.ingredient_id, link.recipe_id, link.quantity, link.measurement, recipes.recipe_name, recipes.instructions, ingredients.ingredient_name, recipes.instructions, recipes.cook_time FROM link LEFT JOIN ingredients ON link.ingredient_id=ingredients.ingredient_id LEFT JOIN recipes ON link.recipe_id=recipes.recipe_id WHERE link.recipe_id=? ");

    $stmt -> bind_param('i', $recipe_id);
    $stmt -> execute();
    $res = $stmt->get_result();
   

    $recipe_name = 'Did you add ingredients and quantity to the recipe ';
    $info = "<ul>";
   // if($stmt->num_rows > 0){
        while($row=$res->fetch_assoc()){
            $instructions = $row['instructions'];
            $cook_time = $row['cook_time'];
            $m = '';
            if($row['measurement'] !== ''){
                $m = $row['measurement'];
            }
            $recipe_name = $row['recipe_name'];
            $info .= "<li>" . $row['ingredient_name'] . ": " . (intval($row['quantity'])*$num) . " " . $m . "</li>";
        }
  //  }
    $info .= "</ul>";
    // display instructions: time to cook, instructions

} 
 //if needed to display minutes to prepare
//  $print_or_not = $cook_time > 0 ? $cook_time . ' minutes': '';
?>
<h3><?php echo ucfirst($recipe_name) . " for $num"; ?></h3>
<?php echo $info; ?>
<div class="instructions">
   <p>Cooking time: <?php echo $cook_time > 0 ? $cook_time . ' minutes': '' ?> </p>
   <p>Instructions: <?php echo $instructions ?></p>
</div>
<a href="index.php">Return to main menu</a><br/>
<a href="add_recipe.php">Add New Recipe</a>