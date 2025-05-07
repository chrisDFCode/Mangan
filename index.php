<?php
session_start();
include('connect.php');
include('security.php');

// Simple login check
if (!Security::isLoggedIn()) {
    header("Location: signin.php");
    exit();
}
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
    <style>
        .card {
            height: auto;  /* Change from fixed height to auto */
            min-height: 550px;  /* Set minimum height instead */
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 4px rgba(71, 60, 57, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-img-top {
            height: 300px;  /* Increased height from 200px to 300px */
            object-fit: cover;
        }

        .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1.25rem;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: bold;
            color: #473c39;
            margin-bottom: 0.5rem;
        }

        .card-text {
            font-size: 0.9rem;
            color: #473c39;
            /* Limit description to 3 lines */
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .price-text {
            font-weight: bold;
            color: #473c39;
            margin: 1rem 0;
        }

        .quantity-section {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .quantity-label {
            margin-right: 10px;
            color: #473c39;
            font-family: Arial, sans-serif;
        }

        .quantity-input {
            text-align: center;
            color: #473c39;
            font-family: Arial, sans-serif;
            width: 40px !important;  /* Reduced width */
            -moz-appearance: textfield; /* Firefox */
        }

        /* Remove up/down arrows for Chrome, Safari, Edge, Opera */
        .quantity-input::-webkit-outer-spin-button,
        .quantity-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .input-group.quantity-group {
            width: 100px;  /* Adjusted width */
            display: inline-flex;
        }

        .quantity-btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            color: #473c39;
            border-color: #473c39;
            background-color: white;
        }

        .quantity-btn:hover {
            background-color: #473c39;
            color: white;
        }

        .btn-custom {
            background-color: #473c39;
            color: white;
            font-family: Arial, sans-serif;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #362e26;
        }

        /* Add media query for mobile devices */
        @media (max-width: 768px) {
            .card {
                min-height: auto;  /* Remove minimum height on mobile */
                height: 100%;     /* Take full height of container */
            }

            .card-body {
                padding: 1rem;    /* Reduce padding on mobile */
            }

            .card-img-top {
                height: 200px;    /* Reduce image height on mobile */
            }

            .add-to-cart-form {
                margin-top: auto; /* Push form to bottom */
                padding-top: 1rem;
            }

            .quantity-section {
                margin-bottom: 0.5rem;
            }
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            flex: 1;
        }

        .footer {
            margin-top: auto;
            width: 100%;
            background-color: var(--bs-tertiary-bg);
            padding: 1rem 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="content-wrapper">
        <!-- first child -->
      <nav class="navbar navbar-expand-lg navbar-custom text-center">
            <div class="container-fluid">
            <img src="../logo/Mangan.png" alt="" class="" href = "index.php" style="width: 25%; height: 26%; margin-bottom: -45px; margin-top: -55px; margin-right: -8%; margin-left: 3px;">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item text-center">
                    <a class="nav-link active" aria-current="page" href="index.php" style="color: #473c39; font-family: 'Arial', sans-serif; font-size: 1rem;">Menu</a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="cart.php" style="color: #473c39; font-family: 'Arial', sans-serif; font-size: 1rem;">Cart</a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href= "https://www.instagram.com/mangan_bychriss?igsh=amJuNW9yZXNmajR1&utm_source=qr" target="_blank" style="color: #473c39; font-family: 'Arial', sans-serif; font-size: 1rem;">Contact Us</a>
                </li>
                <!-- Update the Profile Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #473c39; font-family: 'Arial', sans-serif; font-size: 1rem;">
                        <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle"></i> My Account</a></li>
                        <li><a class="dropdown-item" href="order_history.php"><i class="fas fa-history"></i> Order History</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </li>
                </ul>
                <form class="d-flex ms-3" role="search" method="GET" action="index.php" style="margin-left: 1%; margin-right: 1%;">
                <input class="form-control" type="search" name="search" placeholder="Search" aria-label="Search" style="color: #473c39; font-family: 'Arial', sans-serif; font-size: 1rem; height: 38px;">
                </form>
            </div>
            </div>
        </nav>
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
                        <div class="col-md-3">
                            <div class="card">
                                <img src="../logo/' . htmlspecialchars($row['image']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">
                                <div class="card-body">
                                    <div>
                                        <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>
                                        <p class="card-text">' . htmlspecialchars($row['description']) . '</p>
                                        <p class="price-text">Price: ' . number_format($row['price'], 2) . ' Pesos</p>
                                    </div>
                                    <form method="POST" class="add-to-cart-form">
                                        <div class="quantity-section">
                                            <span class="quantity-label">Quantity:</span>
                                            <div class="input-group quantity-group">
                                                <button type="button" class="btn btn-outline-secondary btn-sm quantity-btn" data-action="decrease">-</button>
                                                <input type="number" class="form-control quantity-input" 
                                                       id="quantity-' . $row['id'] . '" 
                                                       name="quantity" value="1" min="1" max="10" readonly>
                                                <button type="button" class="btn btn-outline-secondary btn-sm quantity-btn" data-action="increase">+</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="menu_id" value="' . $row['id'] . '">
                                        <button type="submit" class="btn btn-custom">Add to Cart</button>
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
    
    <!-- Footer -->
    <footer class="footer">
        <p class="mb-0">All rights reserved © Designed by Chris-2025</p>
    </footer>

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
    crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Quantity selector functionality
            $('.quantity-btn').click(function() {
                const input = $(this).closest('.input-group').find('.quantity-input');
                const currentVal = parseInt(input.val());
                
                if ($(this).data('action') === 'increase') {
                    if (currentVal < 10) input.val(currentVal + 1);
                } else {
                    if (currentVal > 1) input.val(currentVal - 1);
                }
            });

            // Existing add to cart functionality
            $('.add-to-cart-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    type: 'POST',
                    url: 'add_to_cart.php',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message);
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Failed to add item to cart');
                    }
                });
            });
        });
    </script>
</body>
</html>