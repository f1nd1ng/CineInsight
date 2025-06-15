<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons (Optional but nice touch) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Google Font: Open Sans -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to right, #e3f2fd, #ffffff);
      font-family: 'Open Sans', sans-serif;
    }
    .card {
      margin-top: 100px;
      border: none;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }
    .form-control {
      border-radius: 12px;
    }
    .btn-success {
      border-radius: 12px;
      font-weight: 600;
    }
    .login-icon {
      font-size: 2rem;
      color: #198754;
    }
    .card-title {
      font-weight: 600;
    }
    .fade-in {
      animation: fadeIn 0.6s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
<div class="container fade-in">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card p-4">
        <div class="text-center mb-3">
          <i class="bi bi-person-circle login-icon"></i>
          <h3 class="card-title mt-2">Welcome Back</h3>
          <p class="text-muted small">Please login to continue</p>
        </div>

        <?php
        if (isset($_POST["Login"])) {
          $usern = $_POST["username"];
          $pass = $_POST["password"];
          require_once("./connectdb.php");
          $sql = "SELECT * FROM Users WHERE username='$usern'";
          $result = $conn->query($sql);
          $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
          if ($user) {
            if (password_verify($pass, $user["password"])) {
              $_SESSION['user'] = $usern;
              $_SESSION['id'] = $user["id"];
              header("Location: home.php");
              die();
            } else {
              echo "<div class='alert alert-danger'>Incorrect password.</div>";
            }
          } else {
            echo "<div class='alert alert-danger'>Username not found.</div>";
          }
        }
        ?>

        <form method="POST" action="login.php">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter username" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
          </div>
          <button type="submit" name="Login" class="btn btn-success w-100">Login</button>
        </form>

        <div class="text-center mt-3">
          <small class="text-muted">Don't have an account? 
            <a href="sign_up.php" class="text-success fw-semibold">Sign up here</a>
          </small>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
