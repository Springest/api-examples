<?php
function get_trainings($base, $page_size = 10, $offset = 0) {
    $url = sprintf('%s&size=%d&offset=%d', $base, $page_size, $offset);
    echo "Opening $url\n";

    $doc = simplexml_load_file($url);
    $total = intval($doc->meta->results);
    $trainings = $doc->trainings;

    if ($offset == 0) {
        $fh = fopen('trainings.xml', 'w');
        fwrite($fh, '<?xml version="1.0" encoding="UTF-8"?><trainings>');
    }

    foreach($trainings as $training) {
        $fh = fopen('trainings.xml', 'a');
        fwrite($fh, $training->training->asXML());
    }

    if ($offset >= $total) {
        $fh = fopen('trainings.xml', 'w');
        fwrite($fh, '</trainings');
    }

    # Find the next link and open it, if it exists
    if($offset < $total) {
      get_trainings($base, $page_size, ($offset + $page_size));
    }
    echo "Finished crawling\n";
}

get_trainings('http://data.springest.nl/trainings.xml?api_key=YOUR_API_KEY');