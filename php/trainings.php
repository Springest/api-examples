<?php

function get_trainings($base, $page_size = 10, $offset = 0) {
    $fh = fopen('trainings.xml', 'w');
    fwrite($fh, '<?xml version="1.0" encoding="UTF-8"?><trainings>');
    do {
        $url = sprintf('%s&size=%d&offset=%d', $base, $page_size, $offset);
        echo "Opening $url\n";
        $doc = simplexml_load_file($url);
        $total = intval($doc->meta->results);
        foreach($doc->trainings->training as $training) {
            fwrite($fh, $training->asXML());
        }
        $offset += $page_size;
    } while($offset < $total);
    fwrite($fh, '</trainings>');
    fclose($fh);
    echo 'Finished crawling. Data written to trainings.xml';
}

get_trainings('http://data.springest.nl/trainings/search.xml?query=testen&api_key=YOUR_API_KEY&fields=id');