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
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <img src="./Logo/Mangan.png" alt="" class="logo">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-meals dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Meals
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
          <li class="nav-about">
          <a class="nav-link" href="#">About Us</a>
        </li>
        <li class="nav-cart">
          <a class="nav-link" href="#"><i class="fa-solid fa-cart-shopping"></i> <sup>1</sup></a>
        </li>
        <li class="nav-faq">
          <a class="nav-link" href="#">FAQ</a>
        </li>
        <li class="nav-login">
        <a class="nav-link" href="#">Register</a>
        </li>
        <li class="nav-register">
        <a class="nav-link" href="#">LogIn</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-light" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

<!-- second child -->
 <nav class="navbar navbar-expand-lg bg-body-tertiary">
<ul class="navbar-nav me-auto">
<li class="nav-item">
  <a class="nav-link" href="#">Welcome</a>
  </li>
  <li class="nav-item">
  <a class="nav-link" href="#">Login</a>
  </li>
</ul>
</nav>
<!-- third child -->
 <div class="bg-light">
  <h3 class="text-center">Our Meals</h3>
  <p class="text-center">Healthy meals your way, with a diet made simple.</p>
 </div>
<!-- fourth child -->
<div class="container">
  <div class="row justify-content-center">
    <!--meals-->
    <div class="row">
      <div class="col-md-3">
        <div class="card">
          <img src="./Logo/poach.png" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Poached Meal</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Add</a>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <img src="./Logo/salad.png" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Salad</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Add</a>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <img src="./Logo/Burrito.png" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Burrito</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Add</a>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <img src="./Logo/rice.png" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Rice in a Box</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Add</a>
          </div>
        </div>
      </div>
    </div>
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
</body>
</html>