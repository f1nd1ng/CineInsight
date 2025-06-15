<?php
require_once('./connectdb.php');

    $ch = curl_init();
    for($id=1;$id<=250;$id++){

        $sql = "SELECT href FROM Movies WHERE id=$id";
        $result = $conn->query($sql)->fetch_assoc();

        $href=$result["href"];

         // Set the URL
        curl_setopt($ch, CURLOPT_URL, "https://www.imdb.com{$href}");

    // Set the HTTP method
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    // Return the response instead of printing it out
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    // Send the request and store the result in $response
    $response = curl_exec($ch);
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML($response);
    libxml_clear_errors();

    $xpath = new DOMXPath($doc);
    $query3 ='/html/body/div[@id="__next"]/main//section/div//section/div/div /div/section/p';//movie description
    $result3=$xpath->query($query3);
    $query4='/html/body/div[@id="__next"]/main//div/ul/li[@data-testid="title-details-languages"]/div/ul//li';//language
    $result4=$xpath->query($query4);
    
    //poster
    $posternode=$xpath->query('//div[@data-testid="hero-media__poster"]/div/img')->item(0);
    $poster=substr(explode(',',$posternode->getAttribute("src"))[0],0,-3);

    //movie description
        $summary=$xpath->query('.//span',$result3->item(0))->item(1)->nodeValue;

    //trailer
    $query='/html/body/div[@id="__next"]/main/div/section[@class="ipc-page-background ipc-page-background--base sc-304f99f6-0 fSJiHR"]/div/section/div/div[@class="sc-a83bf66d-1 gYStnb ipc-page-grid__item ipc-page-grid__item--span-2"]';
        $result=$xpath->query($query)->item(0);

        $trailernode = $xpath->query('./section[@data-testid="videos-section"]/div[@role]/div[@data-testid]//*[@data-testid="videos-slate-card-title-1"]',$result)->item(0);
        if($trailernode!=NULL){
            $trailer= $trailernode->getAttribute("href");
            $trailer = mysqli_real_escape_string($conn,$trailer);
        }
        else {
            $trailer=NULL;
        }

    //sanitizing text input
    $summary = mysqli_real_escape_string($conn,$summary);
    $poster = mysqli_real_escape_string($conn,$poster);

    //inserting poster,movie description and trailer into table Movies
    $sql = "UPDATE Movies
         SET trailer_link='$trailer',poster_image='$poster',movie_description='$summary'
         WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Updated {$id} movie successfully";
        } else {
            echo "Error creating table: " . $conn->error;
        }

        echo PHP_EOL;
    //language
        foreach($result4 as $language){
            $language= $language->nodeValue;
            $sql="INSERT INTO Languages (id,lang)
                VALUES ($id,'$language')";
        if ($conn->query($sql) === TRUE) {
            echo "Inserted movie successfully";
        } else {
            echo "Error creating table: " . $conn->error;
        }  
        }
     //genres
    $genres=$xpath->query('//div[@data-testid="genres"]/div[@class="ipc-chip-list__scroller"]/a/span');
    foreach($genres as $node){
        $genre= mysqli_real_escape_string($conn,$node->nodeValue);

        $sql = "INSERT INTO Genres (id, genre)
        VALUES ($id, '$genre')";

        if ($conn->query($sql) === TRUE) {
            echo "Inserted {$id} movie genre successfully";
        } else {
            echo "Error creating table: " . $conn->error;
        }

        echo PHP_EOL;
    }
    }

 $conn->close();
?>