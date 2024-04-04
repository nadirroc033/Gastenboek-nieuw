<?php

function getBerichten()
{
    $jsonData = file_get_contents('gastenboek.json');
    return json_decode($jsonData, true)['berichten'];
}

function addBericht($naam, $bericht, $afbeelding, $datum)
{
    // deze data moeten wij eerst sanitizen

    $sanitizedNaam = filter_var($naam, FILTER_SANITIZE_STRING);
    // <script>alert('XSS')</script>
    // wordt:
    // alert('XSS')
    $sanitizedBericht = filter_var($bericht, FILTER_SANITIZE_STRING);

    $jsonData = file_get_contents('gastenboek.json');
    $data = json_decode($jsonData, true);

    $data['berichten'][] = array(
        'naam' => $sanitizedNaam,
        'datum' => $datum, // Datum toegevoegd
        'bericht' => $sanitizedBericht,
        'afbeelding' => $afbeelding // Dit is een voorbeeld, je moet de afbeelding op de juiste manier opslaan en verwerken
    );

    file_put_contents('gastenboek.json', json_encode($data, JSON_PRETTY_PRINT));
}


?>