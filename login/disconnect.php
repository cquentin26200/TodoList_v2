<?php
session_start();
try {
    $base = new PDO('mysql:host=127.0.0.1;dbname=todo_list', 'root', '');
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE todo_info SET status = :status";
    $resultat = $base->prepare($sql);
    $resultat->execute(array("status" => 0));
    header("Location: ../index.php");
    $resultat->closeCursor();
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
session_destroy();
header("Location: login.php");
