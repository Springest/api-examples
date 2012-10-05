<?php

function post_review($url, $xmlcontent) {
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array (
            "Content-Type: text/xml; charset=utf-8"
        ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "review=" . $xmlcontent);
    
    return curl_exec($ch);
}

$url = 'http://data.springest.dev:3000/reviews.xml?api_key=9c23a69e23dfaefea805121ca537579d6104e99ca89802c71739b2d1a0591240';

$review = '<?xml version="1.0" encoding="UTF-8"?>
<review>
    <first_name>John</first_name>
    <last_name>Doe</last_name>
    <email>john@doe.com</email>
    <institute-id type="integer">1</institute-id>
    <training-id type="integer">1</training-id>
    <rating-general>5</rating-general>
    <description>
        Donec ullamcorper nulla non metus auctor fringilla. Maecenas faucibus mollis interdum. Donec sed odio dui.
    </description>
    <training-month type="integer">12</training-month>
    <training-year type="integer">2011</training-year>
</review>';

post_review($url, $review);