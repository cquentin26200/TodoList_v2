<?php
session_start();
try {
    if (!empty($_POST["email"]) && !empty($_POST["login"]) && !empty($_POST["password"])) {
        $uid = uniqid();
        $base = new PDO('mysql:host=127.0.0.1;dbname=todo_list', 'root', '');
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql2 = "SELECT email, login FROM user_info WHERE email = :email OR login = :login";
        $resultat2 = $base->prepare($sql2);
        $resultat2->execute(array("email" => $_POST["email"], "login" => $_POST["login"]));
        $sql = "INSERT INTO user_info (user_id, password, email, login) VALUES (:user_id, :password, :email, :login)";
        $resultat = $base->prepare($sql);
        $ligne = $resultat2->fetch();
        if (!$resultat2->rowCount() > 0) {
            $resultat->execute(array("user_id" => $uid, "password" => htmlentities($_POST["password"]), "email" => htmlentities($_POST["email"]), "login" => htmlentities($_POST["login"])));
            header("Location: login.php");
        } else {
            if ($ligne["email"] == $_POST["email"] && $ligne["login"] == $_POST["login"]) {
                header("Location: register.php?login_email=error");
            } else if ($ligne["login"] == $_POST["login"]) {
                header("Location: register.php?login=error");
            } else if ($ligne["email"] == $_POST["email"]) {
                header("Location: register.php?email=error");
            }
        }
        $resultat->closeCursor();
    } else {
        header("Location: register.php");
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
