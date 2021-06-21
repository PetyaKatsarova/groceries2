<?php
include_once 'dbconnection.php';
include_once 'add_recipe_logic.php';
?>

<!-- first form: add recipe to the recipes table -->
<head>
    <link href="styles.css" type="text/css" rel="stylesheet" />
</head>
<h3>Add Recipe And/Or Ingredient</h3>

<form method="post" >
    <label for="add_recipe">Recipe Name</label>
    <input type="text" name="add_recipe" id="add_recipe" />
    <label for="instructions">Instructions</label>
    <textarea name="instructions" name="instructions"></textarea>
    <label for="cook_time">Cooking Time In Min</label>
    <input type="number" name="cook_time" />
    <input type="submit" value="Add New Recipe Name" name="submit_add_new_recipe" />
</form> 

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
    <label for="measurement">Measurement:</label>
    <input type="text" name="measurement" />
    <input type="submit" value="Add Ingredients to the recipe" name="add_to_link" />

    <div>
    <select name="delete_ingredient_from_recipe" id="delete_ingredient_from_recipe">
            <?php
            foreach($ingrs as $key=>$val){
            ?>
                <option value="<?php echo $key ?>" ><?php echo $val ?></option>;
            <?php
    }
            ?>
        </select> 
    <input type="submit" value="Delete Ingredients from the recipe" name="delete_from_link" />
    </div>
</form>

<!-- third form: add ingredients to the ingredients table -->
<form method="post" action="">
    <label for="new_ingredient">Add Ingredient To The List</label>
    <input type="text" name="new_ingredient" />
    <input type="submit" value="Submit" />
</form>

<!-- delete ingredient from ingredients table -->
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


