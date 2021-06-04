<?php
include_once 'dbconnection.php';
echo 'from add recipe2';
// include_once 'add_recipe_logic.php';

//logic: check if ingredient is not already in the ingredients table
$stmt = $db->query("SELECT ingredient_name, ingredient_id FROM ingredients");
$ingrs = [];
if($stmt->num_rows > 0){
    while($row=$stmt->fetch_assoc()){
        $ingrs[$row['ingredient_id']]=$row['ingredient_name'];
    }
}
asort($ingrs);

// logic: check if recipe is not already in recipes table
$st = $db->query("SELECT recipe_name, recipe_id FROM recipes");
$recipe_names = [];
$isDub = false;
while($row=$st->fetch_assoc()){
    $recipe_names[$row['recipe_name']] = $row['recipe_id'];
}
ksort($recipe_names);

?>
<!-- add recipe to the recipe table -->
<head>
    <link href="styles.css" type="text/css" rel="stylesheet" />
</head>
<h3>Add Recipe</h3>
    <p>1.populate link table with select recipe name post and add to the link ingr_id: for all check if not already in the table!!</p>

<form method="post" >
    <label for="add_recipe">Name</label>
    <input type="text" name="add_recipe" id="add_recipe" />
    <textarea name="instructions" name="instructions" placeholder="Add instructions"></textarea>
    <input type="submit" value="Add New Recipe Name" name="submit_add_new_recipe" />
</form> 

<!-- add recipe name to recipe table logic -->
<?php

if(isset($_POST['submit_add_new_recipe'])){
    $name = strtolower($_POST['add_recipe']);
    $instructions= $_POST['instructions'];
    $ingredients = [];


    // checking if the new recipe is in the db:
    foreach($recipe_names as $rec=>$rec_id){
        if($rec === $name){
            echo ucfirst($rec) . " is already in the database";
            $isDub = true;
        }
    }
    if(empty($name) || empty($instructions)){
        echo 'Please enter recipe name and/or instructions';
    }else{
        if($isDub === false){
            $q = "INSERT INTO recipes (recipe_name, instructions)
            VALUES('". $name ."', '". $instructions ."')";
            if ($db->query($q) === TRUE) {
                echo "New recipe created successfully";
            } else {
                echo "Error: " . $q . "<br>" . $db->error;
            }
        }            
    } 
}
?>
<!-- second form: add to link ingredients, recipe, measure and quantity to link -->

<form method="post">
   <label for="recipe"> Recipe </label>
   <select name="recipe_for_link">
   <?php
   foreach($recipe_names as $name=>$id){
            ?>
                <option value="<?php echo $id ?>" ><?php echo $name ?></option>;
            <?php
    }
            ?>
   </select>

   <label for="link_ingredient"> Ingredient </label>
   <select name="ingredient_for_link">
   <?php
   foreach($ingrs as $id=>$name){
            ?>
                <option value="<?php echo $id ?>" ><?php echo $name ?></option>;
            <?php
    }
            ?>
   </select>

 
    <label for="quantity">Quantity: </label>
    <input type="number" name="quantity" />
    <label for="measurement">Enter measurement:</label>
    <input type="text" name="measurement" />
    <input type="submit" value="Add Ingredients to the recipe" name="add_to_link" />
</form>
<!-- logic: to add ingrs, measur, quant, recipe in link and check if already recipe is not in link -->
<?php
$link_ingredients_id = [];
$link_recipes_id = [];
$notDublicatedRecipeIngredient = true;
$notDublicatedRecipeName = true;

if(isset($_POST['add_to_link']) && isset($_POST['quantity']) && (!empty($_POST['quantity']))){

    $ingredient = $_POST['ingredient_for_link'];
    $recipe = $_POST['recipe_for_link'];
    $quantity = $_POST['quantity'];
    $measurement = $_POST['measurement'];

    //make arr with existing ingrs with the same recipe name in link table
    $link_ingredient = $db->query("SELECT ingredient_id FROM link");

    while($row=$link_ingredient->fetch_assoc()){
        array_push($link_ingredients_id, $row['ingredient_id']);
    }

    foreach($link_ingredients_id as $id){
        if($ingredient === $id){
            $notDublicatedRecipeIngredient = false;
        }
    }
    // make an arr with recipe_ids in link table
    // $link_recipe = $db->query("SELECT recipe_id FROM link");

    // while($row=$link_recipe->fetch_assoc()){
    //     array_push($link_recipes_id, $row['recipe_id']);
    // }

    // foreach($link_recipes_id as $id){
    //     if($_POST['recipe_for_link'] === $id){
    //         $notDublicatedRecipeName = false;
    //     }
    // }

    //add ingr, measurement, quant to recipe in link
    if($notDublicatedRecipeIngredient && $notDublicatedRecipeName){
        if(!empty($measurement)){
                $qu = "INSERT INTO link (recipe_id, ingredient_id, quantity, measurement)
            VALUES('". $recipe ."', '". $ingredient ."', '". $quantity ."', '". $measurement ."')";
            if ($db->query($qu) === TRUE) {
                echo "New recipe ingredients and quantity were created successfully";
            } else {
                echo "Error: " . $db->error;
            }
        }else{
            $qu = "INSERT INTO link (recipe_id, ingredient_id, quantity)
            VALUES('". $recipe ."', '". $ingredient ."', '". $quantity ."')";
            if ($db->query($qu) === TRUE) {
                echo "New recipe ingredients and quantity were created successfully";
            } else {
                echo "Error: " . $db->error;
            }
        }
    }else{
        echo "You have already this ingredient or recipe in the recipes database";
    }

}


?>

<!-- third form: add ingredients to the list -->
<form method="post" action="">
    <label for="new_ingredient">Add Ingredient To The List</label>
    <input type="text" name="new_ingredient" />
    <input type="submit" value="Submit" />
</form>
<!-- logic to add new ingredient to ingredients table -->
<?php
// to recycle in forms: delete and select recipe to add ingredients
;

$new_ingredient = isset($_POST['new_ingredient']) ? $_POST['new_ingredient'] : false;
$stmt2 = false;
if(!empty($new_ingredient)){
    if (!in_array($new_ingredient, $ingrs)) {
        $stmt2 = $db->query("INSERT INTO ingredients (ingredient_name)
                       VALUES ('" . $new_ingredient . "')");
    }else{
        echo "The ingredient exist in the databes, select it from the list above.";
    }
}
if($stmt2 === TRUE){
    echo "New record created successfully";
} else {
    // echo "Error: " . $new_ingredient . "<br>" . $db->error;

};

?>
<!-- delete ingredient -->
<form method="post">
    <label for="delete_ingredient">Delete Ingredient From The List</label>
        <select name="delete_ingredient" id="delete_ingredient">
            <?php
            foreach($ingrs as $key=>$val){
            ?>
                <option value="<?php echo $key ?>" ><?php echo $val ?></option>;
            <?php
    }
            ?>

        </select> 
        <input type="submit" name="submitted_delete_ingredient" />
</form>
<a href="index.php">Return to main menu</a>
<!-- delete ingredient from ingredients table -->
<?php 
   
if(isset($_POST['delete_ingredient'])){
    $del_ingredient = $_POST['delete_ingredient'];
    $del = $db->query("DELETE FROM ingredients WHERE ingredient_id = '". $del_ingredient ."'");
    if($del){
        echo 'Ingredient successfully deleted';
    }
}
?>

