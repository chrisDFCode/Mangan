<?php
include ('./includes/connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mangan</title>
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    <!-- font -->
    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer" />
    <!-- css file -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- navbar -->
    <div class="container-fluid p-0">
        <!-- first child -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary navbar-custom">
            <div class="container-fluid">
                <img src="./Logo/Mangan.png" alt="" class="logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php">Cart</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search" method="GET" action="index.php">
                        <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-light" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- second child -->
        <div class="bg-light">
            <h3 class="text-center">Our Meals</h3>
            <p class="text-center">Healthy meals your way, with a diet made simple.</p>
        </div>

        <!-- fourth child -->
        <div class="container">
            <div class="row justify-content-center">
                <?php
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $sql = "SELECT * FROM menu WHERE name LIKE '%$search%'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '
                        <div class="col-md-3">
                            <div class="card">
                                <img src="./Logo/' . $row['image'] . '" class="card-img-top" alt="' . $row['name'] . '">
                                <div class="card-body">
                                    <h5 class="card-title">' . $row['name'] . '</h5>
                                    <p class="card-text">' . $row['description'] . '</p>
                                    <p class="card-text">Price: ' . $row['price'] . ' Pesos</p>
                                    <form method="POST" class="add-to-cart-form">
                                        <input type="hidden" name="menu_id" value="' . $row['id'] . '">
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </form>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    echo '<p class="text-center">No meals found.</p>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
    crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.add-to-cart-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    type: 'POST',
                    url: 'add_to_cart.php',
                    data: form.serialize(),
                    success: function(response) {
                        alert('Item added to cart successfully.');
                    },
                    error: function() {
                        alert('Failed to add item to cart.');
                    }
                });
            });
        });
    </script>
</body>
</html>