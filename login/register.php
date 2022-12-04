<?php
$title = "Register";
include_once "../includes/header.php";
?>

<form action="verif_register.php" method="POST" class="m-3">
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" required>
        <?php
        if (isset($_GET["email"]) || isset($_GET["login_email"])) { ?>
            <p class="text-danger" style="font-size: 13px;">Mail déjà utilisé</p>
        <?php }
        ?>
    </div>
    <div class="mb-3">
        <label for="login" class="form-label">login</label>
        <input type="text" class="form-control" id="login" name="login" required>
        <?php
        if (isset($_GET["login"]) || isset($_GET["login_email"])) { ?>
            <p class="text-danger" style="font-size: 13px;">login déjà utilisé</p>
        <?php }
        ?>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<a href="login.php" class="ms-3">Se connecter</a>