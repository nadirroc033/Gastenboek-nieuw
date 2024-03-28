<?php

function getBerichten()
{
    $jsonData = file_get_contents('gastenboek.json');
    return json_decode($jsonData, true)['berichten'];
}

function addBericht($naam, $bericht, $afbeelding, $datum)
{
    $jsonData = file_get_contents('gastenboek.json');
    $data = json_decode($jsonData, true);

    $data['berichten'][] = array(
        'naam' => $naam,
        'datum' => $datum, // Datum toegevoegd
        'bericht' => $bericht,
        'afbeelding' => $afbeelding // Dit is een voorbeeld, je moet de afbeelding op de juiste manier opslaan en verwerken
    );

    file_put_contents('gastenboek.json', json_encode($data, JSON_PRETTY_PRINT));
}


?>