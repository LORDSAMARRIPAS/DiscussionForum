<?php
require_once '../php/config.php'; 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$isLoggedIn = isset($_SESSION['username']);

function getLoginLogoutLink($isLoggedIn) {
    if ($isLoggedIn) {
        return "<li class='nav-item'><a class='btn btn-outline-success mx-2' href='" . BASE_URL . "/views/accountPage.html'>Account</a></li>" .
               "<li class='nav-item'><a class='btn btn-outline-success mx-2' href='" . BASE_URL . "/php/logout.php'>Logout</a></li>";
    } else {
        return "<li class='nav-item'><a class='btn btn-outline-success mx-2' href='" . BASE_URL . "/views/login.html'>Login</a></li>" .
               "<li class='nav-item'><a class='btn btn-outline-primary mx-2' href='" . BASE_URL . "/views/register.html'>Register</a></li>";
    }
}
function getCreateForumLink($isLoggedIn) {
  if ($isLoggedIn) {
      return "<li class='nav-item'><a class='nav-link' href='" . BASE_URL . "/views/createForum.html'>Create Forum</a></li>";
  } else {
      return "";
  }
}

echo "<nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
  <div class='container-fluid'>
    <a class='navbar-brand' href='" . BASE_URL . "/views/Home.html'>
      <img src='" . BASE_URL . "/drawable/LOGO1.png' alt='Logo' style='height: 56px;'> Gaming Enthusiasts Hub
    </a>
    <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
      <span class='navbar-toggler-icon'></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarNav'>
      <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
        <li class='nav-item'>
          <a class='nav-link' href='" . BASE_URL . "/views/Home.html'>Home</a>
        </li>" .
        getCreateForumLink($isLoggedIn) . "
      </ul>
      <form class='d-flex justify-content-center' action='" . BASE_URL . "/php/search_script.php' method='get' style='flex-grow: 1;'>
  <div class='d-flex' style='position: relative; max-width: 400px; flex-grow: 1; margin-right: 10px;'>
    <input class='form-control' type='search' placeholder='Search' aria-label='Search' name='search' style='width: 100%;'>
  </div>
  <button class='btn btn-outline-info' type='submit' style='background-color: #00adee; color: white;'>Search</button>
</form>

    

      <div class='d-flex'>" .
        getLoginLogoutLink($isLoggedIn) .
      "</div>
    </div>
  </div>
</nav>";
?>

