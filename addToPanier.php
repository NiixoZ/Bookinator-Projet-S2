<?php
declare(strict_types=1);

require_once "autoload.php";
require_once "src/Utils.php";

init_php_session();
if(!isLogged())
    header('Location: index.php');

$id='';
if(isset($_GET['id']) && !empty($_GET['id']) && ctype_digit($_GET['id']))
    $id=$_GET['id'];
else
    header('Location: index.php');

Utilisateur::createFromId($_SESSION['idUtilisateur'])->getPanier()->addContenu($id);
header('Location: Article.php?idArticle='.$id);