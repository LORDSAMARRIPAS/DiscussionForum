<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home - Gaming Enthusiasts Hub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="../css/styles.css"> <!-- Add your custom CSS file here -->
  <style>
    /* Custom styles for search results */
    .search-results {
      margin-top: 20px;
    }
    .search-result-item {
      margin-bottom: 10px;
      padding: 10px;
      background-color: #f8f9fa; /* Light gray background */
      border-radius: 5px;
      cursor: pointer;
    }
    .search-result-item:hover {
      background-color: #e9ecef; /* Light gray background on hover */
    }
    .search-result-item a {
      text-decoration: none;
      color: #007bff; /* Blue color for links */
      font-weight: bold;
      display: block; /* Display as block to make entire div clickable */
      text-align: center; /* Center text */
    }
    .search-result-item a:hover {
      text-decoration: underline; /* Underline links on hover */
    }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?> <!-- Include your navigation bar -->

  <div class="container">
    <h1>Search Results</h1>
    <div class="search-results">
      <?php if (!empty($_SESSION['search_results'])): ?>
        <?php foreach ($_SESSION['search_results'] as $result): ?>
          <div class="search-result-item" onclick="window.location='../views/forumPage.html?forumname=<?php echo $result['forumname']; ?>'">
            <a href="../views/forumPage.html?forumname=<?php echo $result['forumname']; ?>"><?php echo $result['forumname']; ?></a>
          </div>
        <?php endforeach; ?>
        <?php unset($_SESSION['search_results']); ?>
      <?php else: ?>
        <p>No results found.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Bootstrap JavaScript dependencies -->
  <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha384-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="../scripts/dynamic-navbar.js"></script> <!-- Add your custom JavaScript file here -->
</body>
</html>
