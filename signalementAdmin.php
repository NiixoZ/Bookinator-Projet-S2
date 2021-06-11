<?php
declare(strict_types=1);

require_once "autoload.php";
require_once "src/Utils.php";
init_php_session();

$webPage = new WebPage("Signalement Admin");
$webPage->appendContent(getHeader());
$webPage->appendCssUrl("src/style.css");

/** Récupération des signalements */
$signs=MyPDO::getInstance()->prepare(<<<SQL
        SELECT *
        FROM Signalement
        ORDER BY dateSig
    SQL);

$signs->execute();
$signs=$signs->fetchAll();

$resultSigns='';
foreach ($signs as $sign) {
    $type=Signalement::getTypeSig($sign['idSignalement']);
    $user=Utilisateur::createFromId((int)$sign['idUtilisateur']);
    $resultSigns .= <<<HTML
        <tr>
            <th scope="row">{$sign['dateSig']}</th>
            <td>$type</td>
            <td>{$user->getMail()} <a href="" </td>
            <td></td>
        </tr>
HTML;
}

$html = <<<HTML
    <div class="d-flex flex-column justify-content-center">
        <div class="d-flex font-size-36 dark-text main-color-background mt-5 mb-5 px-5 border-radius-5 align-self-center">Signalements</div>
        <div class="d-flex flex-column px-5 pb-5">
            <table class="table table-striped table-bordered table-dark">
                <thead class="main-text-color">
                    <tr>
                      <th scope="col">Date</th>
                      <th scope="col">Type</th>
                      <th scope="col">Utilisateur</th>
                    </tr>
                </thead>         
                <tbody>
                    $resultSigns
                </tbody>
            </table>
        </div>            
    </div>       
HTML;

$webPage->appendContent($html);
$webPage->appendContent(getFooter());
echo $webPage->toHTML();