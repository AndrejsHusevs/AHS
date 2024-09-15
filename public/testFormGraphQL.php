<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Classes\Models\Category;
use App\Classes\Models\Language;
use App\Classes\Models\Attribute;
use App\Classes\Models\TextAttribute;
use App\Classes\Models\SwatchAttribute;
use App\Classes\Models\Product;
use App\Classes\Models\ProductNameDescription;
use App\Classes\Models\ProductGallery;
use App\Classes\Models\AttributeItem;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GraphQL TESTING PAGE</title>
</head>
<body>
    <h1>GraphQL TESTING PAGE</h1>
   
    <form id="graphqlForm">
        <textarea id="queryInput" name="query" rows="10" cols="80">{ categories { id name } }</textarea><br />
        <input type="submit" value="Send Query" />
    </form>

    <div id="responseOutput"></div>

    <script>
    document.getElementById('graphqlForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        var query = document.getElementById('queryInput').value;
        var jsonQuery = JSON.stringify({ query: query });

        fetch('/ahs/public/graphql', { // Ensure this matches the route in index.php
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: jsonQuery
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
            document.getElementById('responseOutput').innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
        })
        .catch((error) => {
            console.error('Error:', error);
            document.getElementById('responseOutput').innerHTML = '<pre>' + error + '</pre>';
        });
    });
</script>

    <hr>
    <?php

$categoryModel = new Category();

/*
    echo "<hr>Categories:<br/>";                
    print_r($categoryModel->getAllCategoryNamesByLanguageId("english"));
*/  
 
/*
    echo "<hr>Languages:<br/>";
    $languageModel = new Language();  
    print_r($languageModel->getAll());
*/

/*
    echo "<hr>Attributes:<br/>";
    $swatchAttributeModel = new SwatchAttribute();
    $swatchAttributes = $swatchAttributeModel->getAll();
    $textAttributeModel = new TextAttribute();
    $textAttributes = $textAttributeModel->getAll();
    $allAttributes = array_merge($swatchAttributes, $textAttributes);
    print_r($allAttributes);
*/

    echo "<hr>Products:<br/>";
    $productModel = new Product();
    $products = $productModel->getAll();

    $productNameDescriptionModel = new ProductNameDescription();
    $productGalleryModel = new ProductGallery();
    $attributeItemModel = new AttributeItem();

    foreach ($products as &$product) {
        
        $productNameDescription = $productNameDescriptionModel->getByProductIdAndLanguageId($product['id'], 'english');
        if ($productNameDescription) {
            $product['name'] = $productNameDescription['name'];
            $product['description'] = $productNameDescription['description'];
        }
        echo $product['id'] . "__________" . $product['name'] . "<br/>";

        /*
        $productGalleries = $productGalleryModel->getByProductId($product['id']);        
        foreach ($productGalleries as $productGallery) {
            echo "__________" . $productGallery['link'] . "<br/>";
        }
        */
        // Fetch and print attribute items for the product
        echo "Categories:<br/>";
        $category = $categoryModel->getCategoryNameByProductIdAndLanguageId($product['id'], 'english');
        $product['category'] = $category['name'] ?? null;
        echo "__________" . $product['category'] . "<br/>";

/*
        // Fetch and print attribute items for the product
        echo "Attributes:<br/>";
        $uniqueAttributes = $attributeItemModel->getUniqueAttributesByProductId($product['id']);
        foreach ($uniqueAttributes as $uniqueAttribute) {
            echo "__________" . $uniqueAttribute['attribute_id'] . ":<br/>";
            $attributeItems = $attributeItemModel->getItemsByAttributeIdAndProductId($uniqueAttribute['attribute_id'], $product['id']);
            foreach ($attributeItems as $attributeItem) {
                echo "____________________" . $attributeItem['displayvalue'] . "<br/>";
            }
        }   
*/
        echo "<br/><br/>";
    }



    ?>

</body>
</html>