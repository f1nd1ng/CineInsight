<?php
    $ch = curl_init();

    // Set the URL
    curl_setopt($ch, CURLOPT_URL, "https://www.imdb.com/chart/top/?ref_=nv_mv_250");

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

    $query2='/html/body/div[@id="__next"]/main/div/div/section/div/div/div[@data-testid="chart-layout-main-column"]/ul/li/div[@class="ipc-metadata-list-summary-item__c"]/div/div';
    $result2=$xpath->query($query2);

    require_once('./connectdb.php');

    foreach($result2 as $node)
    {
        $node1=$xpath->query('.//a',$node);
        $href = $node1->item(0)->getAttribute("href");//href
        
        $title = $xpath->query('.//h3',$node)->item(0)->nodeValue;
            $id = explode('.',$title)[0];//id
            $name = explode('.',$title)[1];//movie name

        //sanitizing text input
        $name = $conn -> real_escape_string($name);
        $href = $conn -> real_escape_string($href);

        $year=$xpath->query('.//span',$node)->item(0)->nodeValue;//release year

        $duration=$xpath->query('.//span',$node)->item(1)->nodeValue;//duration of the movie

        $rating=$xpath->query('.//span/div/span',$node)->item(0)->nodeValue;
        $rating=substr(explode('(',$rating)[0],0,-2);//imdb rating
        
        // inserting into table Movies
        $sql = "INSERT INTO Movies (id,movie_name,href,rating,duration,release_year)
                VALUES ($id, '$name', '$href', $rating , '$duration', $year )";

        if ($conn->query($sql) === TRUE) {
            echo "Inserted {$name} movie successfully";
        } else {
            echo "Error creating table: " . $conn->error;
        }

        echo PHP_EOL;
    }

    curl_close($ch);
?>