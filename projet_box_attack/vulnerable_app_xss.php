<?php
// Affiche les informations PHP sur la page
echo "<h1>Vulnérabilité XSS</h1>";

// Vérifier si le paramètre 'name' existe dans l'URL
if (isset($_GET['name'])) {
    // Affiche le nom de l'utilisateur sans validation, introduisant une faille XSS
    echo "<p>Hello, " . $_GET['name'] . "!</p>";
} else {
    echo "<p>Hello, please enter your name in the URL (e.g., ?name=YourName).</p>";
}
?>
