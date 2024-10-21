<!-- products.php -->
<?php
$mysqli = new mysqli("localhost", "root", "", "shoppingcart");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <style>
        /* style.css */

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    color: #333;
}

.container {
    max-width: 1200px;
    margin: 0 auto; /* Center the container */
    padding: 20px;
}

h1 {
    text-align: center;
    color: #4CAF50; /* Green color */
}

.product-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    margin: 20px 0; /* Space around product list */
}

.product {
    background: white;
    border-radius: 5px;
    padding: 10px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
}

.product img {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
}

.product h2 {
    font-size: 1.2em;
    color: #333;
}

.product .price {
    color: #4CAF50; /* Price color */
    font-weight: bold;
}

.product:hover {
    transform: scale(1.05); /* Zoom effect on hover */
}

.pagination {
    text-align: center;
    margin: 20px 0; /* Space around pagination */
}

.pagination-button {
    padding: 10px 15px;
    background-color: #4CAF50; /* Button color */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin: 0 5px; /* Space between buttons */
}

.pagination-button:hover:not([disabled]) {
    background-color: #45a049; /* Darker green on hover */
}

.pagination-button[disabled] {
    background-color: #ccc; /* Disabled button color */
    cursor: not-allowed; /* No cursor for disabled */
}

    </style>
</head>
<body>
    <h1>Products</h1>
    <div id="product-list"></div>
    <div id="pagination"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let currentPage = 1;

        function loadProducts(page) {
            $.ajax({
                url: 'fetch_products.php',
                type: 'GET',
                data: {
                    category_id: <?= $category_id ?>,
                    page: page
                },
                dataType: 'json',
                success: function(response) {
                    $('#product-list').empty();
                    response.products.forEach(function(product) {
                        $('#product-list').append(`
                            <div class="product">
                                <h2>${product.name}</h2>
                                <p>Price: ${product.price}</p>
                                <img src=" ./assets/images/${product.image}" alt="${product.name}">
                            </div>
                        `);
                    });
                    renderPagination(response.total_pages, page);
                },
                error: function(xhr, status, error) {
                    console.error("Error: ", error);
                }
            });
        }

        function renderPagination(totalPages, currentPage) {
            $('#pagination').empty();
            for (let i = 1; i <= totalPages; i++) {
                $('#pagination').append(`
                    <button onclick="changePage(${i})" ${i === currentPage ? 'disabled' : ''}>${i}</button>
                `);
            }
        }

        function changePage(page) {
            currentPage = page;
            loadProducts(page);
        }

        $(document).ready(function() {
            loadProducts(currentPage);
        });
    </script>
</body>
</html>
