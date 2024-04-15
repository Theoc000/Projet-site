<?php
include "connexionBDD.php"
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
 
</head>
<body>
    

<?php

if (!empty($_POST['login']) && !empty($_POST['mdp'])) 
{
    
    $pdo = cnx(); 

    if ($pdo) 
    {
        $sql = "SELECT login, mdp FROM utilisateur WHERE login = :login"; 
      

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':login' => $_POST['login'])); 

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) 
        {
            $mdpHash = hash('sha256', $_POST['mdp']);

            if ($mdpHash === $row['mdp']) 
            {
                header("Location: site.php");
                exit;
            } 
            else 
            {
                $message ="<br/> Mot de passe incorrect.";
            }
        } 
        else 
        {
            $message = "<br/>" . $_POST['login'] . " n'existe pas !";
        }
    }
    else
    {
        $message ="La connexion à la base de données a échoué.";
    }
}  
?>
            
    <div class="login-container">
    <h2>Connexion</h2>
    <form class="login-form" action="index.php" method="post">
        <div>
            <label for="login">Nom d'utilisateur :</label>
            <input type="text" id="login" name="login" required>
        </div>
        <div>
            <label for="mdp">Mot de passe :</label>
            <input type="password" id="password" name="mdp" required>
        </div>
        <input type="submit" value="Se connecter">
    </form>
    <?php if(isset($message)) { echo "<p>$message</p>"; } ?>
    </div>
</body>





<!--  CSS PAGE D'ACCUEIL!-->
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            text-align: center;
        }

        .login-form {
            margin-top: 20px;
        }

        .login-form label {
            display: block;
            margin-bottom: 10px;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        .login-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-form input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</html>
