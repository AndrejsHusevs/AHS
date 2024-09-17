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
        <textarea id="queryInput" name="query" rows="10" cols="80">
            {
             product(id: "apple-imac-2021") {
                    id
                    name
                    gallery
                    price_amount
                    price_currency_symbol
                    description
                    attributes {
                        id
                        name
                        items {
                            id
                            display_value
                        }
                    }
                }
            }
        </textarea><br />
        
        <input type="submit" value="Send Query" />
    </form>
    <hr>

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


</body>
</html>