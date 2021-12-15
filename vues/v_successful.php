<?php
/**
 * vue seccessful
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @author    Maestracci Rémi <>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
?>     
<?php
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($action) {
    case 'miseEnPaiement':
        $word = 'mise en paiement.';
        break;
//    case 'ValiderFrais':
//        $word = 'validée.';
//        break;
}
?>

<div class="alert alert-success" role="alert">
    <?php
    $infoVi = $pdo->getNomPrenomVisiteur($_SESSION['idUser']);
    echo 'La fiche de frais du visiteur ' . $infoVi['prenom'] . ' ' . $infoVi['nom'] . ' a bien été '. $word;
    ?>
</div>