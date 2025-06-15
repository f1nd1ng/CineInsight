<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    
<head>
  <meta charset="UTF-8">
  <title>Movie Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap CSS -->


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>

body {
  background: linear-gradient(to bottom right, #e9f5ec, #ffffff);
}

.navbar {
  border-bottom: 1px solid #d3e5dd;
}

.form-section {
  border: 1px solid #d1e7dd;
  background: #ffffffcc;
  padding: 2.5rem;
  border-radius: 24px;
}

input, .dropdown-toggle, .form-control {
  border-radius: 12px !important;
  border: 1px solid #ced4da;
}

.card {
  border-radius: 20px;
  overflow: hidden;
  background-color: #fdfdfd;
  box-shadow: 0 4px 20px rgba(0,0,0,0.05);
  transition: all 0.3s ease-in-out;
}

.card:hover {
  transform: translateY(-6px);
  box-shadow: 0 8px 24px rgba(0,0,0,0.08);
}

.card-title {
  font-weight: 600;
  color: #1c4332;
}

.card-body {
  background-color: #ffffff;
  padding: 1rem;
}

.btn-success {
  background-color: #1c4332;
  border: none;
  font-weight: 600;
}

.btn-success:hover {
  background-color: #14532d;
}


  </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light px-4 mb-4">
  <a class="navbar-brand" href="#">🎬 CineInsight</a>
  <div class="ms-auto">
    <a href="./userprofile.php" class="btn btn-outline-primary me-2">User Details</a>
    <a href="./login.php" class="btn btn-outline-danger">Log out</a>
  </div>
</nav>

<div class="container">
<?php
  require('./connectdb.php');
  $userid = $_SESSION['id'] ?? null;
  if (!$userid) {
    echo "<div class='alert alert-danger'>You are not logged in. Please <a href='login.php'>login</a>.</div>";
    exit();
  }
  $sqll = "SELECT movieid FROM UserMovies WHERE id='$userid'";
  $resultt = $conn->query($sqll);
?>

<script>
window.onload = function () {
<?php
  if ($resultt->num_rows > 0) {
    while ($roww = $resultt->fetch_assoc()) {
      $id1 = $roww["movieid"];
      echo "let el = document.getElementById('butt$id1'); if(el){ el.style.background='yellow'; el.classList.add('fav'); }\n";
    }
  }
?>
}
</script>

<!-- Filter Form -->
<div class="container mb-4">
  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="form-section">

    <h5 class="mb-3 text-primary">🎬 Search & Filter Movies</h5>

    <!-- Movie Name Search -->
    <div class="mb-3">
      <label class="form-label">Movie Name</label>
      <input type="text" name="search" value="<?php echo $_POST['search'] ?? '' ?>" class="form-control" placeholder="Enter movie name...">
    </div>

    <!-- Genre Dropdown -->
    <div class="mb-3 dropdown">
      <label class="form-label d-block">Select Genre</label>
      <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start" type="button" data-bs-toggle="dropdown">
        Choose Genres
      </button>
      <ul class="dropdown-menu w-100 p-3" style="max-height: 250px; overflow-y: auto;">
        <div class="row row-cols-2 row-cols-md-3 g-2">
        <?php
          $sql = "SELECT DISTINCT genre FROM Genres";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
            $genre = $row["genre"];
            echo '<div class="form-check col">';
            echo "<input class='form-check-input' type='checkbox' name='$genre' id='$genre'>";
            echo "<label class='form-check-label' for='$genre'>$genre</label>";
            echo '</div>';
          }
        ?>
        </div>
      </ul>
    </div>

    <!-- Language Dropdown -->
    <div class="mb-3 dropdown">
      <label class="form-label d-block">Select Language</label>
      <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start" type="button" data-bs-toggle="dropdown">
        Choose Languages
      </button>
      <ul class="dropdown-menu w-100 p-3" style="max-height: 250px; overflow-y: auto;">
        <div class="row row-cols-2 row-cols-md-3 g-2">
        <?php
          $sql = "SELECT DISTINCT lang FROM Languages";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
            $lang = $row["lang"];
            echo '<div class="form-check col">';
            echo "<input class='form-check-input' type='checkbox' name='$lang' id='$lang'>";
            echo "<label class='form-check-label' for='$lang'>$lang</label>";
            echo '</div>';
          }
        ?>
        </div>
      </ul>
    </div>

    <!-- IMDb Range -->
    <div class="row g-2 mb-3">
      <div class="col">
        <label class="form-label">Min IMDb</label>
        <input type="number" step="0.1" name="min-imdb" min="1" max="10" class="form-control" placeholder="e.g. 7.0">
      </div>
      <div class="col">
        <label class="form-label">Max IMDb</label>
        <input type="number" step="0.1" name="max-imdb" min="1" max="10" class="form-control" placeholder="e.g. 9.5">
      </div>
    </div>

    <div class="d-grid">
      <button type="submit" name="submit" class="btn btn-success">Apply Filters</button>
    </div>
  </form>
</div>

<!-- Movie Cards -->
<div class="row row-cols-1 row-cols-md-4 g-4 movie-cards">
<?php
  $searchname = $_POST["search"] ?? '';
  require_once('./filter_query.php');

  $sql = "SELECT * FROM Movies WHERE movie_name LIKE '%$searchname%' {$genre_id_query} {$lang_id_query} {$imdb_id_query}";
  $result = $conn->query($sql);   

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $id = $row["id"];
      $href = $row["href"];
      $name = $row["movie_name"];
      $rating = $row["rating"];
      $duration = $row["duration"];
      $poster = $row["poster_image"];
      $summary = $row["movie_description"];
      require('./card.php');
    }
  } else {
    echo "<div class='col'><div class='alert alert-warning text-center'>No movies found for the given filters.</div></div>";
  }
?>
</div>

</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
