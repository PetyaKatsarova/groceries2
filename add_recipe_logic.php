<?php
include_once 'dbconnection.php';

//check if ingredient is not already in the ingredients table

$stmt = $db->query("SELECT ingredient_name, ingredient_id FROM ingredients");
$ingrs = [];
if($stmt->num_rows > 0){
    while($row=$stmt->fetch_assoc()){
        $ingrs[$row['ingredient_id']]=$row['ingredient_name'];
    }
}
asort($ingrs);

// add new ingredient to ingredients table

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

//delete ingredient from ingredients table

if(isset($_POST['delete_ingredient'])){
    $del_ingredient = $_POST['delete_ingredient'];
    $del = $db->query("DELETE FROM ingredients WHERE ingredient_id = '". $del_ingredient ."'");
    if($del){
        echo 'Ingredient successfully deleted';
    }
}

// check if recipe is not already in recipes table

$st = $db->query("SELECT recipe_name, recipe_id FROM recipes");
$recipe_names = [];
$isDub = false;
while($row=$st->fetch_assoc()){
    $recipe_names[$row['recipe_name']] = $row['recipe_id'];
}
ksort($recipe_names);

// add recipe name to recipe table 

if(isset($_POST['submit_add_new_recipe'])){
    $name = strtolower($_POST['add_recipe']);
    $instructions= $_POST['instructions'];
    $ingredients = [];


    // checking if the new recipe is in the recipes table:

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

//add ingrs, measur, quant, recipe in link and check if ingr is not already in link 

$link_ids = [];
$notDublicatedRecipeIngredient = true;

if(isset($_POST['add_to_link']) && isset($_POST['quantity']) && (!empty($_POST['quantity']))){

    $ingredient = intval($_POST['ingredient_for_link']);
    $recipe = intval($_POST['recipe_for_link']);
    $quantity = $_POST['quantity'];
    $measurement = $_POST['measurement'];


    //make sure there r no dublicates ingredients for the same recipe in the link table

    $link_ingredient = $db->query("SELECT recipe_id, ingredient_id FROM link");

    while($row=$link_ingredient->fetch_assoc()){
        $temp = [intval($row['recipe_id']), intval($row['ingredient_id'])];
        array_push($link_ids, $temp);
    }
   
    for($i=0; $i<count($link_ids); $i++){
        for($j=0; $j<count($link_ids[$i])-1; $j+=2){
            if(($link_ids[$i][$j] === $recipe) && ($link_ids[$i][$j+1] === $ingredient)){
                $notDublicatedRecipeIngredient = false;
                break;   
            }             
        }
    }
     //add ingr, measurement, quant to recipe in link
     if($notDublicatedRecipeIngredient){
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
        echo "You have already this recipe in the recipes database or the same recipe in this recipe already";
    }
}