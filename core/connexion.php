<?php 
// Fichier   de   connexion   à   MySQL   (connexion.php).   Nous   avons   déjà   dû créer   ce   fichier   lors   de   la   création   du   site   web   précédent.   Je   vous   invite à   vous   y   référencer.

$dbconfig = $config['database'];
try
{
    $bdd = new PDO(
        'mysql' .
        ':host=' . $dbconfig['host'] .
        ';dbname=' . $dbconfig['dbname'] .
        ';port=' . $dbconfig['dbport'] . 
        ';charset=utf8' ,
        $dbconfig['user'] ,
        $dbconfig['password']
    );
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}



 ?>