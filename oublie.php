<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset='utf-8'>
        <link href='css/app.css' rel='stylesheet'/>
        <title>mot de passe oublier</title>
    </head>
    
<header class="gbaf-header">
    <img width="100" src="inc/logo/GBAF_logo.png" alt="logo du gbaf">
    <h1>Extranet GBAF</h1>
    <p></p>
</header>

<main>
<!-- formulaire de soumission du username-->
<div class="groupe-form container">
    <form method="post">
        <label class="group-label" for="username">Quel est votre nom utilisateur ?</label>
        <input class="form-control" type="text" name="username" id="username"><br />
        <input class="btn btn-primary" type="submit" value="valider" name="submit_username">
    </form>
</div>

<!-- vérification  du usernam-->
<?php
if(isset($_POST['submit_username'])){
    $bdd = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '');
    $req = $bdd->query('SELECT username FROM comptes');
while($reponse = $req->fetch())
    
        if($_POST['username'] == ($reponse['username'])){
               header('Location: nouveau_password.php?user='.$_POST["username"].'');
        }
}
?>
<?php require 'inc/footer.php'?>