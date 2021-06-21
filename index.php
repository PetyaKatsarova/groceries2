<?php
include_once 'dbconnection.php';
?>

<head>
   <link href="styles.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <h3>Recipes</h3>
  
    <form method="post" action="groceries_list.php" name="selected_recipe"> 
        <div>
            <label for="recipe_id">Enter Recipe Name</label> 
            <select name="recipe_id" id="recipe_id">
                <?php
                    include 'display_recipe_names.php';
                ?>
            </select>
            <label for="number_pple" id="num_pple">For: </label>
            <input type="number" name="number_pple" value=2 />
        </div>
        <input type="submit" name="submit_groceries_list" id=="submit_groceries_list" value="To the shopping list and instructions" />
    </form> 
  
    <form method="post" name="delete_recipe" action="">
        <label for="delete_recipe_name">Recipe</label>
        <select name="delete_recipe_name" id="delete_recipe_name">
            <?php
                include 'display_recipe_names.php';
            ?>
        </select> 
        <input type="submit" value="Delete" />
    </form>  
    <?php 
        include_once 'delete_recipe_from_db.php';
    ?>
    <a href="add_recipe.php">Add New Recipe</a>
</body>



