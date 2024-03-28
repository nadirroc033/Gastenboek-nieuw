<?php
// Haal de huidige inhoud van het JSON-bestand op
$jsonData = file_get_contents('gastenboek.json');
$data = json_decode($jsonData, true);

// Voeg het nieuwe bericht toe aan de array
$data['berichten'][] = array(
    'naam' => $_POST['naam'],
    'datum' => date("d-m-Y H:i"),
    'bericht' => $_POST['bericht'],
    'afbeelding' => $_FILES['afbeelding']['name'] // Dit is een voorbeeld, je moet de afbeelding op de juiste manier opslaan en verwerken
);

// Schrijf het bijgewerkte JSON-object terug naar het bestand
file_put_contents('gastenboek.json', json_encode($data, JSON_PRETTY_PRINT));


?>