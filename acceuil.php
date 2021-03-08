<?php require 'inc/header.php'?>


<div id='GBAF'>

<h1>Le GBAF</h1>

<p>Le GBAF est le représentant de la profession bancaire et des assureurs sur tous les axes de la réglementation financière française. Sa mission est de promouvoir l'activité bancaire à l'échelle nationale. C'est aussi un interlocuteur privilégié des pouvoirs publics</p>

<hr>
</div>


<div id='acteur'>
    <h1>Les acteurs et partenaires</h2>
    
      <?php
$bdd = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '');
$reponse=$bdd->query('SELECT * FROM partenaires');
while ($donnees=$reponse->fetch()){

    $description = substr($donnees['description'],0, 150);
    
    $format =
    '<div class="partenaire_liste container">
        <div class="logo_partenaire">
            <img class="logo_mini" src="inc/logo/%s" alt="logo %s">
        </div>
        <div class="texte_partenaire container">
            <h3>%s</h3>
            <p>%s...</p>
            <a href="partenaire.php?id=%s" class="btn btn-primary btn-sm btn-lire">lire la suite</a>
        </div>
    </div>';
        
echo sprintf($format, $donnees['logo'], $donnees['nom'], $donnees['nom'], $description, $donnees['id_partenaire']);
}
?>

</div>
<?php require 'inc/footer.php'?>