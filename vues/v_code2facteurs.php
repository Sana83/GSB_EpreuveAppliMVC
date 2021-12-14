/**
 * vue code2facteurs
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @author    Hoarau Tangui <tangui.hoarau@hotmail.com>
 * @author    Lambert Erwan <>
 * @author    Maestracci Rémi <>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="alert alert-info" role="alert">Un email contenant un code à 4 chiffres vous a été envoyé, merci de le saisir ici...</div>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Identification utilisateur - Authentification à deux facteurs (A2F)</h3>
            </div>
            <div class="panel-body">
                <form role="form" method="post"
                      action="index.php?uc=connexion&action=valideA2fConnexion">
                    <fieldset>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-qrcode"></i>
                                </span>
                                <input class="form-control" placeholder="Code"
                                       name="code" type="text" maxlength="4" value="<?php echo $code; ?>">
                            </div>
                        </div>
                        <input class="btn btn-lg btn-success btn-block"
                               type="submit" value="Se connecter">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
