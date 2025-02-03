<?php
include ('connect.php');
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
        <nav class="navbar navbar-expand-lg navbar-custom text-center">
            <div class="container-fluid">
                 <img src="../logo/Mangan.png" alt="" class="" style="width: 25%; height: 26%; margin-bottom: -45px; margin-top: -55px; margin-right: -13%; margin-left: 3px;">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                       <li class="nav-item text-center">
                            <a class="nav-link active" aria-current="page" href="index.php" style="color: #473c39; font-family: 'Arial', sans-serif; font-size: 1rem;">Menu</a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link" href="cart.php" style="color: #473c39; font-family: 'Arial', sans-serif; font-size: 1rem;">Cart</a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link" href="" style="color: #473c39; font-family: 'Arial', sans-serif; font-size: 1rem;">Contact Us</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search" method="GET" action="index.php" style="width: 600px; margin-left: 1%; margin-right: 1%;">
                        <input class="form-control" type="search" name="search" placeholder="Search" aria-label="Search" style="color: #473c39; font-family: 'Arial', sans-serif; font-size: 1rem; height: 38px;">
                    </form>
                </div>
            </div>
        </nav>

        <!-- second child -->
        <div class="mt-4">
            <h3 class="text-center" style="font-weight: bold; font-family: 'Arial', sans-serif; color: #473c31; margin-bottom: 3px;">Our Meals</h3>
            <p class="text-center mb-4" style="font-family: 'Arial', sans-serif; color: #473c39;">Healthy meals your way, with a diet made simple.</p>
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
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <img src="../logo/' . $row['image'] . '" class="card-img-top" alt="' . $row['name'] . '">
                                <div class="card-body">
                                    <h5 class="card-title">' . $row['name'] . '</h5>
                                    <p class="card-text">' . $row['description'] . '</p>
                                    <p class="card-text">Price: ' . $row['price'] . ' Pesos</p>
                                    <form method="POST" class="add-to-cart-form">
                                        <input type="hidden" name="menu_id" value="' . $row['id'] . '">
                                        <button type="submit" class="btn" style="background-color: #473c39; color: white;">Add</button>
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
        <!-- last child -->
 <div class="bg-info p-3 text-center bg-body-tertiary">
  <p> All rights reserved © Designed by Chris-2025</p>
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