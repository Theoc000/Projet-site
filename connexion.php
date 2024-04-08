<?php
include "connexionBDD.php"
?>

<h2> Identification </h2>
 <form action="" method="post">
    <div>
        <label for="login"> Login : </label> <input type="text" name="login" id="login"/><br/>
        <label for="mdp"> Mot de passe : </label> <input type="password" name="mdp" id="mdp"/><br/>
            <input type="submit" value="Envoyer"/>
</div>
</form>


<?php
if (!empty($_POST['login']) && !empty($_POST['mdp'])) {
    
    $pdo = cnx(); 

    if ($pdo) {
        $sql = "SELECT login, mdp FROM utilisateur WHERE login = :login"; 
        
        echo $sql . "<br/>";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':login' => $_POST['login'])); 
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $mdpHash = hash('sha256', $_POST['mdp']);
            
            if ($mdpHash === $row['mdp']) {
                echo "<br/> Vous êtes connecté " . $row['login'];
            } else {
                echo "<br/> Mot de passe incorrect.";
            }
        } else {
            echo "<br/>" . $_POST['login'] . " n'existe pas !";
        }
    }
}
?>
