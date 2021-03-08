<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8/'>
        <link href='css/app.css' rel='stylesheet'/>
        <title>Connection</title>
    </head>
    
<header class="gbaf-header">
    <img width="100" src="inc/logo/GBAF_logo.png" alt="logo du gbaf">
    <h1>Extranet GBAF</h1>
    <p></p>
</header>


<div class="container">
<body>
    <form action='' method='post'>
    
    <div class="form-group">
        <label class="control-label" for="username">Nom d'utilisateur:</label>
        <input type="text" class="form-control" name="username" id="username"/>
    </div>
       
    <div class="form-group">
        <label class="control-label" for="password">Mot de passe:</label>
        <input type="password" class="form-control" name="password" id="password"/>
        <a href="oublie.php">J'ai oublié mon mot de passe</a>
    </div>
       
    <button type='submit' class="btn btn-primary" name='connection'>Connexion</button>
    </form>
    
<?php
    if (isset($_POST['connection']))                                                                   //récupération de l'utilisateur et de son pass haché//
    {
        $bdd = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '');

        $req = $bdd->prepare('SELECT * FROM comptes WHERE username = ?');                      
                $req->execute(array($_POST['username']));
                $resultat = $req->fetch();
                    $correctPassword = password_verify($_POST['password'], $resultat['password']);

        if ($resultat == false || $correctPassword == false)                                            //mauvaise authentification//
                {
                    echo "Mauvais identifiant ou mot de passe.";
                }
        else                                                                                          
                {
                    if($resultat == true AND $correctPassword == true)                                  //bonne authentification//
                        {
                            session_start();
                            $_SESSION['id'] = $resultat['id_compte'];
                            $_SESSION['nom'] = $resultat['nom'];
                            $_SESSION['prenom'] = $resultat['prenom'];
                            $_SESSION['username'] = $resultat['username'];

                            header('Location: acceuil.php');

                        }
                    else
                        {
                            echo "mauvais identifiant ou mot de passe.";
                        }
                }

    }
    else
    {
        
    }
?>

<br />
    <p><a href="inscription.php">Creer un compte</a></p>
    </div>


<?php require 'inc/footer.php'?>

      
  </body>
</html>