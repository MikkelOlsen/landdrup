<?php

    if(secCheckMethod('POST')) {
        $post = secGetInputArray(INPUT_POST);
        $error = [];

        if(!secValidateToken($post['_once'], 600)) {
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }

        if(isset($post['opdaterProfil']))
        {
            $mail = $_SESSION['username'];
            $fornavn     = validCharacter($post['fornavn']) ? $post['fornavn']           : $error['fornavn']     = 'Fornavn skal udfyldes, og må ikke indeholde tal.';
            $efternavn   = validCharacter($post['efternavn']) ? $post['efternavn']       : $error['efternavn']   = 'Efternavn skal udfyldes, og må ikke indeholde tal.';
            $fodselsdato = validDate($post['fodselsdato_submit']) ? $post['fodselsdato_submit']        : $error['fodselsdato'] = 'Fødselsdato skal udfyldes og datoerne deles med / eller -';
            $adresse     = validStringBetween($post['adresse'], 2, 65) ? $post['adresse']: $error['adresse']     = 'Adresse skal udfyldes og må ikke være længere end 65 tegn.';
            $postnr      = validIntBetween($post['postnr'], 4, 5) ? $post['postnr']      : $error['postnr']      = 'Post nr skal udfyldes og må maks indholde 5 tal.';
            $by          = validCharacter($post['city'], 2, 30) ? $post['city']          : $error['city']        = 'By skal udfyldes, og må ikke indeholde tal.';
            $tel         = validTel($post['tlf']) ? validTel($post['tlf'])               : $error['tlf']         = 'Telefon nr skal udfyldes og må kun være tal.';
            if(sizeof($error) === 0){
							if (!sqlQueryPrepared('
								UPDATE `profil` SET `fornavn` = :fornavn, `efternavn` = :efternavn, `fodselsdato` = :fodselsdato, `adresse` = :adresse, `postnr` = :postnr, `city` = :city, `tlf` = :tlf WHERE id = :id
								',array(
									':fornavn' => $fornavn,
									':efternavn' => $efternavn,
									':fodselsdato' => $fodselsdato,
									':adresse' => $adresse,
									':postnr' => $postnr,
									':city' => $by,
									':tlf' => $tel,
                                    ':id' => $_SESSION['profilid']
								))) {
									$error['brugeropret'] = 'Der skete en fejl ved opdateringen.';
								}
								else {
									header('Location: ?p=profil');
								}
			}
            //print_r($post['fodselsdato']);
		} 
    }
?>
<div class="container">
<div class="row">
    
<h1 class="center-align"><b>Din Profil - <?=$user['fornavn'] .' '. $user['efternavn']?></b></h1>


<form class="col s6" action="" method="post" id="eventForm">
    <?php 
        if (isset($error['brugerfindes'])) echo '<div class="alert alert-danger">'.$error['brugerfindes'].'</div>'.PHP_EOL;
        if (isset($error['brugeropret'])) echo '<div class="alert alert-danger">'.$error['brugeropret'].'</div>'.PHP_EOL;
    ?>
    <?=secCreateTokenInput()?>
        <div class="row">
        <div class="input-field col s12">
            <label for="fornavn">Fornavn</label><br />
            <input class="validate" type="text" name="fornavn"  id="fornavn" min="2" max="30" value="<?= $user['fornavn'] ?>"><br />
            <?php
                if (isset($error['fornavn'])) echo '<div class="alert alert-danger">'.$error['fornavn'].'</div>'.PHP_EOL;
            ?>
        </div>
        </div>
        <div class="row">
        <div class="input-field col s12">
            <label for="efternavn">Efternavn</label><br />
            <input class="validate" type="text" name="efternavn"  id="efternavn" min="2" max="30" value="<?= $user['efternavn'] ?>"><br />
            <?php
			if (isset($error['efternavn'])) echo '<div class="alert alert-danger">'.$error['efternavn'].'</div>'.PHP_EOL;
		?>
        </div>
        </div>
        <div class="row">
        <div class="input-field col s12">
            <label for="fodselsdato">Fødsesldato</label><br />
            <input class="validate datepicker" type="date" name="fodselsdato" id="fodselsdato" value="<?= $user['dateCreated'] ?>"><br />
            <?php
			if (isset($error['fodselsdato'])) echo '<div class="alert alert-danger">'.$error['fodselsdato'].'</div>'.PHP_EOL;
		?>
        </div>
        </div>
        <div class="row">
        <div class="input-field col s12">
            <label for="adresse">Adresse</label><br />
            <input class="validate" type="text" name="adresse"  id="adresse" min="2" max="65" value="<?= $user['adresse'] ?>"><br />
            <?php
			if (isset($error['adresse'])) echo '<div class="alert alert-danger">'.$error['adresse'].'</div>'.PHP_EOL;
		?>
        </div>
        </div>
        <div class="row">
        <div class="input-field col s12">
            <label for="postnr">Post nr.</label><br />
            <input class="validate" type="number" name="postnr"  id="postnr" min="0" max="99999" value="<?= $user['postnr'] ?>"><br />
            <?php
			if (isset($error['postnr'])) echo '<div class="alert alert-danger">'.$error['postnr'].'</div>'.PHP_EOL;
		?>
        </div>
        </div>
        <div class="row">
        <div class="input-field col s12">
            <label for="city">By</label><br />
            <input class="validate" type="text" name="city"  id="city" min="2" max="30" value="<?= $user['city'] ?>"><br />
            <?php
			if (isset($error['city'])) echo '<div class="alert alert-danger">'.$error['city'].'</div>'.PHP_EOL;
		?>
        </div>
        </div>
        <div class="row">
        <div class="input-field col s12">
            <label for="tlf">Tlf.</label><br />
            <input class="validate" type="text" name="tlf"  id="tlf" min="8" max="8" value="<?= $user['tlf'] ?>"><br />
            <?php
			if (isset($error['tlf'])) echo '<div class="alert alert-danger">'.$error['tlf'].'</div>'.PHP_EOL;
		?>
        </div>
        </div>
    <input type="submit" class="btn btn-default col-md-3" name="opdaterProfil" value="submit">
</form>

</div>
</div>
  <script>
      $('.datepicker').pickadate({
    selectMonths: true,
    selectYears: 100,
    format: 'dd-mm-yyyy',
    formatSubmit: 'yyyy-mm-dd', 
    min: new Date(1940,1,1),
    max: new Date(2017,31,12)
  });
</script>