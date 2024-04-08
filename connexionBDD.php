<?php
function cnx() {
    $host = 'localhost';
    $db = 'projetstage';
    $user = 'root';
    $co = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $co);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        echo "Connexion à la base de données impossible ! " . $e->getMessage();
        return null;
    }
}
?>