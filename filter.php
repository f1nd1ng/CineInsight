<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once('./connectdb.php');
        $sql = "SELECT DISTINCT genre FROM Genres";
        $result = $conn->query($sql);  
    ?>
    <div class="genres">
        <strong>Select Genre:</strong>
            <?php 
                while($row=$result->fetch_assoc()){
                    echo "<input type='checkbox' name={$row["genre"]} value={$row["genre"]}>{$row["genre"]}";
                }
            ?>
        </select>
    </div>
    <?php
        require_once('./connectdb.php');
        $sql = "SELECT DISTINCT lang FROM Languages";
        $result = $conn->query($sql);  
    ?>
    <div class="langs">
        <strong>Select Language:</strong>
            <?php 
                while($row=$result->fetch_assoc()){
                    echo "<input type='checkbox' name={$row["lang"]} value={$row["lang"]}>{$row["lang"]}";
                }
            ?>
        </select>
    </div>
    <div class="imdb">
        <strong>Select range of Imdb:</strong>
        <input type="number" name="min-imdb"  placeholder="e.g. 1.0" step="0.1" min="1" max="10">
        to 
        <input type="number" name="max-imdb"  placeholder="e.g. 1.0" step="0.1" min="1" max="10">
    </div>
</body>
</html>