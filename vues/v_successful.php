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