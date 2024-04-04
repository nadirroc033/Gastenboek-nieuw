<?php
include 'functions.php';

// Start de sessie
session_start();

// Controleer of er al een bericht is verzonden in de afgelopen minuut
if (isset($_SESSION['laatste_verzending']) && time() - $_SESSION['laatste_verzending'] < 60) {
    // Bereken hoeveel seconden er nog moeten worden gewacht
    $resterende_tijd = 60 - (time() - $_SESSION['laatste_verzending']);
    echo "<p>Je kunt pas weer een bericht versturen na $resterende_tijd seconden.</p>";
    $formulier_versturen = false; // Verberg het formulier
} else {
    // Toon het formulier om een nieuw bericht te versturen
    $formulier_versturen = true;

    // Bericht toevoegen als het formulier is ingediend
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $naam = $_POST['naam'];
        $bericht = $_POST['bericht'];

        // Afbeelding uploaden als er een bestand is geselecteerd
        if (!empty($_FILES['afbeelding']['name'])) {
            $afbeelding = $_FILES['afbeelding']['name'];
            $targetDirectory = "assets/afbeeldingen/"; // Doelmap voor het opslaan van afbeeldingen
            $target_file = $targetDirectory . basename($_FILES["afbeelding"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Controleer of het bestand een afbeelding is
            $check = getimagesize($_FILES["afbeelding"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "Bestand is geen afbeelding.";
                $uploadOk = 0;
            }

            // Controleer of het bestand al bestaat
            if (file_exists($target_file)) {
                echo "Sorry, het bestand bestaat al.";
                $uploadOk = 0;
            }

            // Controleer de bestandsgrootte
            if ($_FILES["afbeelding"]["size"] > 500000) {
                echo "Sorry, je bestand is te groot.";
                $uploadOk = 0;
            }

            // Toegestane bestandsformaten
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo "Sorry, alleen JPG, JPEG, PNG en GIF-bestanden zijn toegestaan.";
                $uploadOk = 0;
            }

            // Probeer het bestand te uploaden als alles in orde is
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["afbeelding"]["tmp_name"], $target_file)) {
                    // Datum toevoegen
                    $datum = date('d-m-Y H:i');
                    addBericht($naam, $bericht, $afbeelding, $datum); // Datum toegevoegd

                    // Markeer de tijd van de laatste verzending
                    $_SESSION['laatste_verzending'] = time();

                    echo "Het bestand " . htmlspecialchars(basename($_FILES["afbeelding"]["name"])) . " is succesvol geüpload.";
                } else {
                    echo "Sorry, er was een probleem met het uploaden van je bestand.";
                }
            }
        } else {
            // Als er geen afbeelding is geüpload, voeg alleen het bericht toe
            $datum = date('d-m-Y H:i');
            addBericht($naam, $bericht, "", $datum); // Datum toegevoegd

            // Markeer de tijd van de laatste verzending
            $_SESSION['laatste_verzending'] = time();

            echo "Bericht zonder afbeelding is succesvol toegevoegd.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastenboek</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <h1>Gastenboek</h1>
        <a href="landingpage.php" class="terug-button">Terug naar de landingpagina</a>


        <!-- Formulier voor het toevoegen van een nieuw bericht -->
        <?php if ($formulier_versturen) { ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                enctype="multipart/form-data">
                <label for="naam">Naam:</label><br>
                <input type="text" id="naam" name="naam" required><br><br>

                <label for="bericht">Bericht:</label><br>
                <textarea id="bericht" name="bericht" rows="4" required></textarea><br><br>

                <label for="afbeelding">Afbeelding:</label><br>
                <input type="file" id="afbeelding" name="afbeelding"><br><br>

                <input type="submit" value="Plaats bericht">
            </form>
        <?php } else { ?>
            <p>Je hebt al een bericht verstuurd. Bedankt!</p>
        <?php } ?>

        <!-- Weergave van alle berichten -->
        <h2 id="berichten-heading">Recente berichten</h2> <!-- ID toegevoegd aan het berichten gedeelte -->
        <div class="berichten">
            <?php
            $berichten = getBerichten();
            foreach ($berichten as $bericht) {
                echo "<div class='bericht'>";
                echo "<p><strong>Naam:</strong> " . $bericht['naam'] . "</p>";
                echo "<p><strong>Datum:</strong> " . $bericht['datum'] . "</p>";
                echo "<p><strong>Bericht:</strong> " . $bericht['bericht'] . "</p>";
                if (!empty($bericht['afbeelding'])) {
                    echo "<img src='assets/afbeeldingen/" . $bericht['afbeelding'] . "' alt='Afbeelding'>";
                }
                echo "</div>";
            }
            ?>
        </div>

    </div>

</body>

</html>