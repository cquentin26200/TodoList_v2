<?php
session_start();
$title = "Accueil";
include_once "includes/header.php";
try {
    $base = new PDO('mysql:host=127.0.0.1;dbname=todo_list', 'root', '');
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT login FROM user_info WHERE user_id = :user_id";
    $resultat = $base->prepare($sql);
    $resultat->execute(array("user_id" => isset($_SESSION["connect"]) ? $_SESSION["connect"] : ""));
    $sql2 = "SELECT item_name, date, hour, id, user_id FROM todo_info";
    $resultat2 = $base->prepare($sql2);
    $resultat2->execute(array());
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>

<body>
    <header class="bg-blue-500 text-white p-4 text-center">
        <h1>TO-DO List</h1>
    </header>
    <main class="text-gray-800">
        <section class="md:w-2/3 mx-auto mt-4 text-center">
            <?php if (isset($_SESSION["connect"])) { ?>
                <div class="add text-center p-2">
                    <p class="mb-3">Connecter en tant que <?= $resultat->fetch()["login"] ?></p>
                    <form action="verif_index.php" method="POST">
                        <input type="text" name="todo" class="border p-2 rounded" placeholder="Nouvel item">
                        <input type="submit" value="Ajouter" class="py-2 px-4 rounded bg-green-500 text-white">
                    </form>
                </div>
                <table class="w-full mt-3 mb-3">
                    <?php while ($ligne2 = $resultat2->fetch()) { ?>
                        <?php if ($ligne2["user_id"]  == $_SESSION["connect"]) { ?>
                            <tr class="border-t-2">
                                <td class="px-4 todo-item p-2 text-left text-capitalize"><?= $ligne2["item_name"] ?> <span class="ml-5">Ajouter le : <?= $ligne2["date"] ?> à <?= $ligne2["hour"] ?></span></td>
                                <td class="hidden todo-input p-2">
                                    <form action="modification/modify.php" method="post" class="text-center">
                                        <input type="text" name="update" class="border p-2 rounded" value="<?= $ligne2["item_name"] ?>">
                                        <input type="hidden" name="id" value="<?= $ligne2["id"] ?>">
                                        <input type="submit" value="Changer" class="py-2 px-4 rounded bg-green-500 text-white">
                                    </form>
                                </td>
                                <td class="todo-actions text-center p-2 flex justify-center">
                                    <form action="modification/status.php" method="post">
                                        <?php $sql3 = "SELECT status FROM todo_info WHERE id = :id";
                                        $resultat3 = $base->prepare($sql3);
                                        $resultat3->execute(array("id" => $ligne2["id"]));
                                        ?>
                                        <?php while ($ligne3 = $resultat3->fetch()) { ?>
                                            <input type="hidden" name="status" value="<?= $ligne2["id"] ?>">
                                            <button class="p-2 rounded w-8 <?= $ligne3["status"] ? "bg-green-500" : "bg-red-500" ?> text-white mr-4"><i class="<?= $ligne3["status"] ? "fas fa-duotone fa-check" : "fa-solid fa-xmark" ?>"></i></button>
                                        <?php } ?>
                                    </form>
                                    <button class="p-2 rounded bg-yellow-500 todo-update mr-4"><i class="fas fa-pen text-white"></i></button>
                                    <form action="modification/delete.php" method="post">
                                        <input type="hidden" name="delete" value="<?= $ligne2["id"] ?>">
                                        <button class="p-2 rounded bg-red-500"><i class="fas fa-trash text-white"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>
                <a href="login/disconnect.php" class="p-2 mt-5 text-decoration-none text-white bg-primary rounded">Se deconnecter</a>
            <?php } else { ?>
                <a href="login/login.php" class="p-2 mt-5 text-decoration-none text-white bg-primary rounded">Se connecter</a>
            <?php } ?>
        </section>
    </main>

    <script>
        let buttons = document.getElementsByClassName('todo-update')
        Array.from(buttons).map(function(element, index) {
            element.addEventListener('click', function() {
                document.getElementsByClassName('todo-item')[index].style.display = 'none'
                document.getElementsByClassName('todo-input')[index].style.display = 'block'
                document.getElementsByClassName('todo-actions')[index].style.display = 'none'

            })
        })
    </script>
</body>

<?php
$resultat->closeCursor();
$resultat2->closeCursor();
?>

</html>