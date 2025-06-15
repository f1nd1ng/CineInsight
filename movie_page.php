<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name ?? 'Movie Details'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500;700&display=swap');

    body {
        background-color: #eef6f1;
        font-family: 'Open Sans', sans-serif;
        padding-top: 4rem;
    }

    .movie-card {
        max-width: 960px;
        margin: 0 auto;
        padding: 2.5rem 2rem;
        background-color: #ffffff;
        border-radius: 24px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
        align-items: flex-start;
    }

    .movie-poster {
        border-radius: 18px;
        width: 100%;
        max-width: 320px;
        height: auto;
        object-fit: cover;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .movie-details {
        flex: 1;
    }

    h1 {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0.2rem;
    }

    h5 {
        font-size: 1rem;
        color: #6c757d;
    }

    p {
        font-size: 1rem;
        line-height: 1.6;
        margin: 1rem 0;
        color: #333;
    }

    .icon-link {
        display: inline-flex;
        align-items: center;
        margin-bottom: 1rem;
        font-weight: 500;
        color: #1C4332;
        transition: 0.3s;
    }

    .icon-link:hover {
        text-decoration: underline;
        color: #145a32;
    }

    .icon-link::before {
        content: '🎬';
        margin-right: 8px;
        font-size: 1.1rem;
    }

    .rating {
        font-size: 1.2rem;
        font-weight: bold;
        color: #198754;
    }

    .duration {
        font-size: 1.1rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }

    .label-title {
        font-weight: 600;
        margin-top: 1rem;
        margin-bottom: 0.3rem;
    }

    .tag {
        display: inline-block;
        background-color: #d8f3dc;
        color: #1C4332;
        padding: 0.4rem 0.8rem;
        border-radius: 12px;
        font-size: 0.85rem;
        margin-right: 0.5rem;
        margin-bottom: 0.4rem;
    }
</style>

</head>
<body>

<?php
    require('./connectdb.php');
    $id = $_GET["id"];
    $sql = "SELECT * FROM Movies WHERE id=$id";
    $result = $conn->query($sql)->fetch_assoc();   

    $trailer = $result["trailer_link"];
    $duration = $result["duration"];
    $name = $result["movie_name"];
    $poster = $result["poster_image"];
    $rating = $result["rating"];
    $summary = $result["movie_description"];
    $year = $result["release_year"];
    $conn->close();
?>

<div class="movie-card">
    <img src="<?php echo $poster ?>" class="movie-poster" alt="Movie Poster"
         onerror="this.onerror=null;this.src='assets/default-image.jpg';">

    <div class="movie-details">
        <h1><?php echo $name ?></h1>
        <h5><?php echo $year ?></h5>

        <p><?php echo $summary ?></p>

        <a href="https://www.imdb.com<?php echo $trailer ?>" class="icon-link" target="_blank">
            Watch Trailer
        </a>

        <div class="rating">IMDb Rating: <?php echo $rating ?></div>
        <div class="duration">⏱ Duration: <?php echo $duration ?></div>

        <div>
            <div class="label-title">Languages:</div>
            <?php
                require('./connectdb.php');
                $sql = "SELECT * FROM Languages WHERE id=$id";
                $result1 = $conn->query($sql); 
                while($row = $result1->fetch_assoc()){
                    echo "<span class='tag'>{$row["lang"]}</span>";
                }
            ?>
        </div>

        <div>
            <div class="label-title">Genres:</div>
            <?php
                $sql = "SELECT * FROM Genres WHERE id=$id";
                $result1 = $conn->query($sql); 
                while($row = $result1->fetch_assoc()){
                    echo "<span class='tag'>{$row["genre"]}</span>";
                }
            ?>
        </div>
    </div>
</div>


</body>
</html>
