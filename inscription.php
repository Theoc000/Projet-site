
<?php
include "connexionBDD.php"
?>



<h2> Création d'un compte </h2>
 <form action="" method="post">
    <div>
        <label for="login"> Login : </label> <input type="text" name="login" id="login"/><br/>
        <label for="mdp"> Mot de passe : </label> <input type="password" name="mdp" id="mdp"/><br/>
        <label for="mdpConf"> Confimer le mot de passe: </label> <input type="password" name="mdpConf" id="mdpConf"/><br/>
            <input type="submit" value="Envoyer"/>
    </div>
</form>




<?php
if (!empty($_POST['login']) && !empty($_POST['mdp']) && $_POST['mdp'] == $_POST['mdpConf']) {
    try {
    
        $pdo = cnx();

        $sql_check = "SELECT COUNT(*) FROM utilisateur WHERE login = :login";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->execute(array(':login' => $_POST['login']));
        $count = $stmt_check->fetchColumn();

        if ($count > 0) {
            echo "<br/>Ce login est déjà utilisé. Veuillez en choisir un autre.";
        } else {

        $sql = "INSERT INTO utilisateur (login, mdp) VALUES (:login, :mdp)";
        $stmt = $pdo->prepare($sql);

        $mdpHash = hash('sha256', $_POST['mdp']);
        $stmt->bindParam(':login', $_POST['login']);
        $stmt->bindParam(':mdp', $mdpHash);

        if ($stmt->execute()) {
            echo "<br/> Login et mot de passe enregistrés<br/>";
        } else {
            echo "<br/> Enregistrement impossible";
        }
    }
    } catch (PDOException $erreur) {
        echo "Erreur : " . $erreur->getMessage();
    }
}
?>

