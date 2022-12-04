<?php
try {
    $base = new PDO('mysql:host=127.0.0.1;dbname=todo_list', 'root', '');
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT status FROM todo_info WHERE id = :id";
    $resultat = $base->prepare($sql);
    $resultat->execute(array("id" => $_POST["status"]));
    $ligne = $resultat->fetch();
    $sql = "UPDATE todo_info SET status = :status WHERE id = :id";
    $resultat = $base->prepare($sql);
    $resultat->execute(array("status" => !$ligne["status"] ,"id" => $_POST["status"]));
    header("Location: ../index.php");
    $resultat->closeCursor();
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
