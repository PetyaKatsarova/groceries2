<?php
include_once 'dbconnection.php';
include_once 'add_recipe_logic.php';
?>
<!-- add recipe to the recipe first form -->
<head>
    <link href="styles.css" type="text/css" rel="stylesheet" />
</head>
<h3>Add Recipe And/Or Ingredient</h3>

<form method="post" >
    <label for="add_recipe">Name</label>
    <input type="text" name="add_recipe" id="add_recipe" />
    <textarea name="instructions" name="instructions" placeholder="Add instructions"></textarea>
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
    <label for="measurement">Enter measurement:</label>
    <input type="text" name="measurement" />
    <input type="submit" value="Add Ingredients to the recipe" name="add_to_link" />
</form>

    <!-- // make an arr with recipe_ids in link table
    // $link_recipe = $db->query("SELECT recipe_id FROM link");

    // while($row=$link_recipe->fetch_assoc()){
    //     array_push($link_recipes_id, $row['recipe_id']);
    // }

    // foreach($link_recipes_id as $id){
    //     if($_POST['recipe_for_link'] === $id){
    //         $notDublicatedRecipeName = false;
    //     }
    // } -->

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

