<?php
session_start();
try {
    $base = new PDO('mysql:host=127.0.0.1;dbname=todo_list', 'root', '');
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM todo_info WHERE id = :id";
    $resultat = $base->prepare($sql);
    $resultat->execute(array("id" => $_POST["delete"]));
    header("Location: ../index.php");
    $resultat->closeCursor();
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
