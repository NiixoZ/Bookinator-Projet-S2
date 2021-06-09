<?php
declare(strict_types=1);

function affichageLivre(string $isbn):string
{
    $livre=Livre::createFromId($isbn);


    $listeAuteur=$livre->getAuteurs();
    $nomsAuteurs='';
    for($i=0; $i<count($listeAuteur);$i++)
    {
        $nomsAuteurs.="<a href='index.php?author[]={$listeAuteur[$i]->getNom()}' class='booki-link'>{$listeAuteur[$i]->getNom()} {$listeAuteur[$i]->getPrnm()}</a>";
        if($i!=count($listeAuteur)-1 && count($listeAuteur)!=1)
            $nomsAuteurs.=", ";
    }


    $listeGenre=$livre->getGenres();
    $nomsGenres='';
    for($i=0; $i<count($listeGenre);$i++)
    {
        $nomsGenres.="<a href='index.php?genre[]={$listeGenre[$i]->getLibGenre()}' class='booki-link'>{$listeGenre[$i]->getLibGenre()}</a>";
        if($i!=count($listeGenre)-1 && count($listeGenre)!=1)
            $nomsGenres.=", ";
    }


    $editeur=Editeur::createFromId($livre->getIdEditeur())->getLibEditeur();

    $favori='<td></td>';
    if(isLogged())
        $favori="<td><a href='addFavoris_trmt.php?isbn=$isbn' class='d-flex justify-content-center flex-md-grow-1 font-size-24 main-color-background dark-text border-radius-5 padding-button font-weight-bold button' style='height:50px; width: 50px;'><3</a></td>";


    $retour="
<div class='d-flex flex-column-reverse flex-md-row font-size-24 align-items-center justify-content-md-center margin-topbottom-art'>
    <div class='m-1 d-flex flex-column w-75'>
        <div class='d-flex flex-row justify-content-between'>
            <span>{$livre->getTitre()}</span>";

    if($livre->getNoteMoyenne()!=-1)
        $retour.="
            <a href='#avis' class='booki-link'>({$livre->getNbAppreciations()} avis) {$livre->getNoteMoyenne()}/5</a>";
    else
        $retour.="
            <span class='booki-link'>({$livre->getNbAppreciations()} avis) Aucune note</span>";

    $retour.="
        </div>
        <table>
            <tr>
                <td>Prix</td>
                <td class='main-text-color'>{$livre->getPrix()} €</td>
             
            </tr>
            <tr>
                <td>Éditeur</td>
                <td><a href='index.php?editeur[]=$editeur' class='booki-link'>$editeur</a></td>
            </tr>
            <tr>
                <td>Auteur</td>
                <td>$nomsAuteurs</td>            
            </tr>
            <tr>
                <td>Année de publication</td>
                <td><a href='index.php?year[]={$livre->getDatePublication()}'  class='booki-link'>{$livre->getDatePublication()}</a></td>               
            </tr>
            <tr>
                <td>Genre</td>
                <td>$nomsGenres</td>                
            </tr>
            <tr>
               <td>Langue</td>
               <td><a href='index.php?langue[]={$livre->getLangue()}' class='booki-link'>{$livre->getLangue()}</a></td>               
            </tr>
            <tr>
                <td>ISBN</td>
                <td class='booki-link'>{$livre->getISBN()}</td>
                $favori
            </tr>
        </table>
        <span>Description :</span>
        <span class='p-3 border-radius-10 description-background description-text'>{$livre->getDescription()}</span>
    </div>
    <img alt='' src='./src/ViewCouverture.php?id={$livre->getIdCouv()}' height='560'>
</div>
";
    return $retour;
}

function affichageAppreciations(string $isbn):string
{
    $livre=Livre::createFromId($isbn);
    $listeAppreciations=$livre->getAppreciations();
    $retour="<div id='avis' class='d-flex flex-column'>";
    foreach ($listeAppreciations as $elmt)
    {
        $utilisateur=Utilisateur::createFromId($elmt->getIdUtilisateur());
        $userPseudo=$utilisateur->getPseudo();
        if($userPseudo==null)
            $userPseudo=$utilisateur->getNom()." ".$utilisateur->getPrenom();
        $retour.="
<div class='m-3 p-4 d-flex flex-column font-size-24 border-radius-10 main-background w-75 align-self-center'>
    <div class='d-flex flex-row justify-content-between'>
        <div>
            <img width='50' height='50' class='border-radius-100' alt='' src='./src/ViewPdP.php?id={$utilisateur->getIdUtilisateur()}'>
            <span class='white-text-color'>$userPseudo</span>
        </div>
        <span class='booki-link'>{$elmt->getNote()}</span>
    </div>
    <textarea class='p-3 d-flex border-radius-5 second-main-background font-size-20 white-text-color' cols='300' rows='6' style='margin-top: 10px;' disabled>{$elmt->getCommentaire()}</textarea>
</div>
";
    }
    $retour.="</div>";

    return $retour;
}

function affichageConnecte(string $isbn):string
{
    $retour="
    <div class='d-flex justify-content-center'>
        <div class ='d-flex flex-column  flex-md-row w-75'>
            <a href='addToPanier.php?id=$isbn' class='d-flex flex-md-grow-1 font-size-24 main-color-background dark-text border-radius-5 padding-button font-weight-bold button'>Ajouter au panier</a>";

    if(Appreciation::exist($isbn, $_SESSION['idUtilisateur']))
    {
        $retour.="<a href='' class='d-flex flex-md-grow-1 font-size-24 main-color-background dark-text border-radius-5 padding-button font-weight-bold button'>Merci de votre retour !</a>";
    }
    else
    {
        $retour.="<a href='addCommentaire.php?id=$isbn' class='d-flex flex-md-grow-1 font-size-24 main-color-background dark-text border-radius-5 padding-button font-weight-bold button'>Rédiger une appréciation</a>";
    }
    $retour.="                               
        </div>
    </div>
    ";
    return $retour;
}