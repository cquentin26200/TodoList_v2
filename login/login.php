<?php
$title = "Login";
include_once "../includes/header.php";
?>

<form action="verif_login.php" method="POST" class="m-3">
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email">
        <?php
        if (isset($_GET["email"]) || isset($_GET["email_password"])) { ?>
            <p class="text-danger" style="font-size: 13px;">Email incorrect</p>
        <?php }
        ?>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
        <?php if (isset($_GET["password"]) || isset($_GET["email_password"])) { ?>
            <p class="text-danger" style="font-size: 13px;">Mot de passe incorrect</p>
        <?php } ?>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<a href="register.php" class="ms-3">S'enregistrer</a>

