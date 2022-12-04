<?php
session_start();
try {
    $uid = uniqid();
    $base = new PDO('mysql:host=127.0.0.1;dbname=todo_list', 'root', '');
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT email, password, user_id FROM user_info WHERE email = :email AND password = :password";
    $resultat = $base->prepare($sql);
    $resultat->execute(array("email" => htmlentities($_POST["email"]), "password" => htmlentities($_POST["password"])));
    $sql2 = "SELECT email, password FROM user_info";
    $resultat2 = $base->prepare($sql2);
    $resultat2->execute(array());
    if (!$resultat->rowCount() > 0) {
        $ligne = $resultat2->fetch();
        if ($ligne["email"] != $_POST["email"] && $ligne["password"] != $_POST["password"]) {
            header("Location: login.php?email_password=error");
        } else if ($ligne["password"] != $_POST["password"] && $ligne["email"] == $_POST["email"]) {
            header("Location: login.php?password=error");
        } else if ($ligne["email"] != $_POST["email"] && $ligne["password"] == $_POST["password"]) {
            header("Location: login.php?email=error");
        }
    } else {
        $_SESSION["connect"] = $resultat->fetch()["user_id"];
        header("Location: ../index.php");
    }

    $resultat->closeCursor();
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
