<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berichten - Gastenboek</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <h1>Berichten</h1>

        <!-- Weergave van alle berichten -->
        <div class="berichten">
            <?php
            include 'functions.php';
            $berichten = getBerichten();
            foreach ($berichten as $bericht) {
                echo "<div class='bericht'>";
                echo "<p><strong>Naam:</strong> " . $bericht['naam'] . "</p>";
                echo "<p><strong>Datum:</strong> " . date('d-m-Y H:i', $bericht['timestamp']) . "</p>";
                echo "<p><strong>Bericht:</strong> " . $bericht['bericht'] . "</p>";
                echo "<img src='assets/afbeeldingen/" . $bericht['afbeelding'] . "' alt='Afbeelding'>";
                echo "</div>";
            }
            ?>
        </div>

        <!-- Terugknop -->
        <div class="terug-knop">
            <a href="index.php" class="button">Terug naar gastenboek</a>
        </div>
    </div>

</body>

</html>