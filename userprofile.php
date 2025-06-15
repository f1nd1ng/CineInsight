<?php
    session_start();
    require('./connectdb.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favourite Movies</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f1f6f4;
            margin: 0;
            padding: 2rem;
            color: #1C4332;
        }
        .profile {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .profile img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 2px solid #1C4332;
            object-fit: cover;
        }
        .username {
            font-size: 1.8rem;
            font-weight: 600;
        }
        h2 {
            margin-bottom: 1rem;
        }
        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
        }
        .movie-card {
            border-radius: 16px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.1);
            overflow: hidden;
            background-color: #fff;
            transition: transform 0.2s;
        }
        .movie-card:hover {
            transform: translateY(-6px);
        }
        .movie-card img {
            width: 100%;
            height: 240px;
            object-fit: cover;
        }
        .movie-info {
            padding: 1rem;
        }
        .movie-title {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.4rem;
        }
        .movie-meta {
            font-size: 0.85rem;
            color: #555;
        }
        .fav {
            border: 2px solid #B5E0D4;
            box-shadow: 0 0 0 2px rgba(181, 224, 212, 0.4);
        }
    </style>
</head>
<body>

<script>
    window.onload = function() {
        <?php
            $highlightSql = "SELECT movieid FROM UserMovies WHERE id={$_SESSION['id']}";
            $resultt = $conn->query($highlightSql);
            if ($resultt && $resultt->num_rows > 0) {
                while($roww = $resultt->fetch_assoc()){
                    $id1 = $roww["movieid"];
                    echo 'document.getElementById("butt'.$id1.'").classList.add("fav");';
                }
            }
        ?>
    }
</script>

<?php
    $user = $_SESSION['id'];
    $username = $_SESSION['user'];
    $query = "SELECT profile_pic FROM Users WHERE id=$user";
    $result_profile = $conn->query($query);

    echo '<div class="profile">';
    if ($result_profile->num_rows > 0) {
        $row = $result_profile->fetch_assoc();
        $profile_src = $row["profile_pic"];
        echo '<img src="upload/' . $profile_src . '" alt="Profile">';
    }
    echo '<div class="username">' . htmlspecialchars($username) . '</div>';
    echo '</div>';
?>

<h2>Favourite Movies</h2>
<div class="movie-grid">
    <?php
        $sql = "SELECT UserMovies.movieid, Movies.id, Movies.href, Movies.movie_name, Movies.rating, Movies.duration, Movies.poster_image FROM UserMovies
                INNER JOIN Movies ON UserMovies.movieid = Movies.id
                WHERE UserMovies.id=$user";

        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $href = $row["href"];
                $name = $row["movie_name"];
                $rating = $row["rating"];
                $duration = $row["duration"];
                $poster = $row["poster_image"];
                echo "<div class='movie-card' id='butt$id'>
                        <a href='$href'><img src='$poster' alt='Poster'></a>
                        <div class='movie-info'>
                            <div class='movie-title'>" . htmlspecialchars($name) . "</div>
                            <div class='movie-meta'>⭐ $rating | ⏱ $duration</div>
                        </div>
                    </div>";
            }
        } else {
            echo "<p>No favourite movies found.</p>";
        }
    ?>
</div>
</body>
</html>
