<?php
session_start();
try {
    if (!empty(trim($_POST["todo"]))) {
        $base = new PDO('mysql:host=127.0.0.1;dbname=todo_list', 'root', '');
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO todo_info (id, user_id, item_name, date, hour) VALUES (:id, :user_id, :item_name, :date, :hour)";
        $resultat = $base->prepare($sql);
        $resultat->execute(array("id" => uniqid(), "user_id" => $_SESSION["connect"], "item_name" => htmlentities($_POST["todo"]), "date" => date("y:m:d"), "hour" => date("h:i:s")));
        $resultat->closeCursor();
    }
    header("Location: index.php");
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
