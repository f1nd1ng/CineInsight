<?php
require_once('./connectdb.php');

// ----------- GENRE FILTER -----------
$genre_query = '';
$genre_id_query = '';

$genreResult = $conn->query("SELECT DISTINCT genre FROM Genres");

if ($genreResult->num_rows > 0) {
    while ($row = $genreResult->fetch_assoc()) {
        $genre = $row["genre"];
        if (isset($_POST[$genre])) {
            $genre_query .= ($genre_query === '') 
                ? "SELECT id FROM Genres WHERE genre='$genre'" 
                : " INTERSECT SELECT id FROM Genres WHERE genre='$genre'";
        }
    }
}

if (!empty($genre_query)) {
    $genreResultSet = $conn->query($genre_query);
    if ($genreResultSet->num_rows > 0) {
        while ($row = $genreResultSet->fetch_assoc()) {
            $id = $row["id"];
            $genre_id_query .= ($genre_id_query === '') 
                ? "( id=$id" 
                : " OR id=$id";
        }
        $genre_id_query .= ')';
        $genre_id_query = ' AND ' . $genre_id_query;
    }
}

// ----------- LANGUAGE FILTER -----------
$lang_query = '';
$lang_id_query = '';

$langResult = $conn->query("SELECT DISTINCT lang FROM Languages");

if ($langResult->num_rows > 0) {
    while ($row = $langResult->fetch_assoc()) {
        $lang = $row["lang"];
        if (isset($_POST[$lang])) {
            $lang_query .= ($lang_query === '') 
                ? "SELECT id FROM Languages WHERE lang='$lang'" 
                : " INTERSECT SELECT id FROM Languages WHERE lang='$lang'";
        }
    }
}

if (!empty($lang_query)) {
    $langResultSet = $conn->query($lang_query);
    if ($langResultSet->num_rows > 0) {
        while ($row = $langResultSet->fetch_assoc()) {
            $id = $row["id"];
            $lang_id_query .= ($lang_id_query === '') 
                ? "( id=$id" 
                : " OR id=$id";
        }
        $lang_id_query .= ')';
        $lang_id_query = ' AND ' . $lang_id_query;
    }
}

// ----------- IMDB FILTER -----------
$min_imdb = $_POST["min-imdb"] ?? '';
$max_imdb = $_POST["max-imdb"] ?? '';
$imdb_id_query = '';

if ($min_imdb !== '' || $max_imdb !== '') {
    $min_imdb = $min_imdb === '' ? 1 : (float)$min_imdb;
    $max_imdb = $max_imdb === '' ? 10 : (float)$max_imdb;

    $imdb_query = "SELECT id FROM Movies WHERE rating BETWEEN $min_imdb AND $max_imdb";
    $imdbResult = $conn->query($imdb_query);

    if ($imdbResult->num_rows > 0) {
        while ($row = $imdbResult->fetch_assoc()) {
            $id = $row["id"];
            $imdb_id_query .= ($imdb_id_query === '') 
                ? "( id=$id" 
                : " OR id=$id";
        }
        $imdb_id_query .= ')';
        $imdb_id_query = ' AND ' . $imdb_id_query;
    }
}
?>
