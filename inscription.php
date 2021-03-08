<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="css/app.css" />
        <title>Inscription</title>
    </head>

    <body>

<header class="gbaf-header">
    <img width="100" src="inc/logo/GBAF_logo.png" alt="logo du gbaf">
    <h1>Extranet GBAF</h1>
    <p></p>
</header>

<!--Création de compte-->
<div class="container">  
<form class="container" action='' method="post"> 
    
    <div class="form-group">
        <label class="control-label" for="prenom">Prénom</label>
        <input type="text" class="form-control" name="prenom" id="prenom"/>
    </div>
        
    <div class="form-group">
        <br /><label class="control-label" for="nom">Nom</label>
        <input type="text" class="form-control" name="nom" id="nom"/>
    </div>
        
    <div class="form-group">    
        <br/><label class="control-label" for="username">Nom d'utilisateur</label>
        <input type="text" class="form-control" name="username" id="username"/>
    </div>

    <div class="form-group">   
        <br/><label class="control-label" for='password'>Mot de passe</label>
        <input type='password' class="form-control" name='password' id='password'/> 
        <label class="control-label" for='password_confirm'>Confirmez le mot de passe</label>
        <input type='password' class="form-control" name='password_confirm' id='password_confirm'/>
    </div>      
        
    <div class="form-group">
        <br /><label class="control-label" for='question'>Choisissez une question secrète</label>
         <select class="custom-select" name="question" id="question">
           <option value="Quelle est votre couleur préférée ?">Quelle est votre couleur préférée ?</option>
           <option value="Quel est votre numéro fétiche ?">Quel est votre numéro fétiche ?</option>
           <option value="Quel est le  nom de votre chien ?">Quel est le nom de votre chien ?</option>
        </select><br />
            <label class="control-label" for='reponse'>Réponse</label>
            <input type='text' class="form-control" name='reponse' id='reponse'/>
    </div>
            <button type="submit" class="btn btn-primary" name="submit_inscription">S'inscrire</button>
    
</form>

<!--enregistrement des donnees-->
<?php
        if(isset ($_POST['submit_inscription'])){
            if(!empty($_POST['prenom']) AND !empty($_POST['nom']) AND !empty($_POST['username']) AND !empty($_POST['password']) AND !empty($_POST['password_confirm']) AND !empty($_POST['reponse'])){
                
                    if($_POST['password'] == $_POST['password_confirm']){
                        
                        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                  
                        $bdd = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '');
                        $req = $bdd->prepare('SELECT username FROM comptes WHERE username = :username');
                        $req->execute(array(
                        'username' => $_POST['username']));
                        $user = $req->fetch();
                        
                            if($user){
                                echo "ce nom utilisateur est déja pris";
                            }
                        
                            else{
                                $req = $bdd->prepare('INSERT INTO comptes(nom, prenom, username, password, question, reponse) VALUES (:nom, :prenom, :username, :password, :question, :reponse)');
                                $req->execute(array(
                                    'prenom' => $_POST['prenom'],
                                    'nom' => $_POST['nom'],                                    
                                    'username' => $_POST['username'],
                                    'password' => $password,
                                    'question' => $_POST['question'],
                                    'reponse' => $_POST['reponse']));
                                
                                header ('Location: connection.php');
                            }

                    }
                    else
                    {
                        $format = '<br /><p class="text-primary">les mots de passe ne sont pas identique</p>';
                        printf ($format);
                      
                    }
                    
              
                
            }else{
                    $format = '<br /><p class="text-primary">Tous les champs doivent être remplies</p>';
                    printf ($format);
                }
        }   
?>
<br /><a href="connection.php">Retourner à la page de connexion.</a>
</div>


<?php require 'inc/footer.php';?>