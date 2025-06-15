<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Google Font: Open Sans -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to right, #e3f2fd, #ffffff);
      font-family: 'Open Sans', sans-serif;
    }
    .card {
      margin-top: 60px;
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
    .signup-icon {
      font-size: 2rem;
      color: #198754;
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
    <div class="col-md-6">
      <div class="card p-4">
        <div class="text-center mb-3">
          <i class="bi bi-person-plus signup-icon"></i>
          <h3 class="card-title mt-2">Create an Account</h3>
          <p class="text-muted small">Join us by filling the form below</p>
        </div>

        <?php
        if (isset($_POST["submit"])) {
          $pname = $_FILES['profile']['name'];
          $path = "upload/" . $pname;
          move_uploaded_file($_FILES['profile']['tmp_name'], $path);

          $user = $_POST["username"];
          $pass = $_POST["password"];
          $c_pass = $_POST["confirm_password"];
          $passwordHash = password_hash($pass, PASSWORD_DEFAULT);

          $errors = [];

          if (empty($user) || empty($pass) || empty($c_pass)) {
            $errors[] = "All fields are required.";
          }
          if ($pass !== $c_pass) {
            $errors[] = "Passwords do not match.";
          }

          require_once('./connectdb.php');
          $sql = "SELECT * FROM Users WHERE username='$user'";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            $errors[] = "Username already exists!";
          }

          if (!empty($errors)) {
            foreach ($errors as $error) {
              echo "<div class='alert alert-danger'>$error</div>";
            }
          } else {
            $sql = "INSERT INTO Users (username, password, profile_pic)
                    VALUES ('$user', '$passwordHash', '$pname')";
            if ($conn->query($sql) === TRUE) {
              $_SESSION['user'] = $user;
              $_SESSION['id'] =$conn->insert_id;
              header("Location: home.php");
              exit();
            } else {
              echo "<div class='alert alert-danger'>Something went wrong. Please try again.</div>";
            }
          }
        }
        ?>

        <form action="sign_up.php" method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter username" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" placeholder="Re-enter password" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Profile Picture</label>
            <input type="file" name="profile" class="form-control">
          </div>
          <button type="submit" name="submit" class="btn btn-success w-100">Sign Up</button>
        </form>

        <div class="text-center mt-3">
          <small class="text-muted">Already have an account? 
            <a href="login.php" class="text-success fw-semibold">Login here</a>
          </small>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
