<?php
$servername = "localhost";
$username = "dbuser";
$password = "dbpassword";
$dbname = "testdb";

// Connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vulnérabilité d'injection SQL
$sql = "SELECT * FROM users WHERE username = '" . $_GET['username'] . "'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"] . " - Name: " . $row["username"] . "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>