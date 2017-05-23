<div class="container center-block">
<div class="row">
<?php
    //print_r('Time: ' . (time() - $_SESSION['TokenAge']));

    if(secCheckMethod('POST')) {
        $post = secGetInputArray(INPUT_POST);
        $error = [];

        if(!secValidateToken($post['_once'], 600)) {
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }

        if(isset($post['opretBruger']))
        {
            $fornavn     = validCharacter($post['fornavn']) ? $post['fornavn']           : $error['fornavn']     = 'Fornavn skal udfyldes, og må ikke indeholde tal.';
            $efternavn   = validCharacter($post['efternavn']) ? $post['efternavn']       : $error['efternavn']   = 'Efternavn skal udfyldes, og må ikke indeholde tal.';
            $fodselsdato = validDate($post['fodselsdato']) ? $post['fodselsdato']        : $error['fodselsdato'] = 'Fødselsdato skal udfyldes og datoerne deles med / eller -';
            $adresse     = validStringBetween($post['adresse'], 2, 65) ? $post['adresse']: $error['adresse']     = 'Adresse skal udfyldes og må ikke være længere end 65 tegn.';
            $postnr      = validIntBetween($post['postnr'], 4, 5) ? $post['postnr']      : $error['postnr']      = 'Post nr skal udfyldes og må maks indholde 5 tal.';
            $by          = validCharacter($post['city'], 2, 30) ? $post['city']          : $error['city']        = 'By skal udfyldes, og må ikke indeholde tal.';
            $tel         = validTel($post['tlf']) ? validTel($post['tlf'])               : $error['tlf']         = 'Telefon nr skal udfyldes og må kun være tal.';
            $mail        = validEmail($post['email']) ? $post['email']                   : $error['email']       = 'Email skal udfyldes og være en gyldig email adresse.';
            $adgangskode = validMatch($post['gentagKode'], $post['kode']) ? $post['kode']: $error['kodematch']   = 'Dine kodeord matcher ikke.';
            $adgangskode = validMixedBetween($post['kode'], 4) ? $post['kode']           : $error['kodeformat']  = 'Din kode er ikke lang nok.';
            if(sizeof($error) === 0){
				if ($stmt = $conn->prepare("SELECT id FROM brugere WHERE email = :mail")) {
					$stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
					if ($stmt->execute()) {
						if ($stmt->rowCount() > 0) {
							$error['brugerfindes'] = 'Den bruger, du prøver at oprette, ekstisterer allerede.';
						}
						else {
							$adgangskode = password_hash($adgangskode, PASSWORD_BCRYPT, ['cost' => 12]);
							if (!sqlQueryPrepared('
								INSERT INTO `profil`(`fornavn`, `efternavn`, `fodselsdato`, `adresse`, `postnr`, `city`, `tlf`) 
								VALUES (:fornavn,:efternavn,:fodselsdato,:adresse,:postnr,:city,:tlf);
								SELECT LAST_INSERT_ID() INTO @lastId;
								INSERT INTO `brugere`(`email`, `password`, `fk_profil`, `fk_brugerrolle`) 
								VALUES (:omg,:nice,@lastId,:wtf)
								',array(
									':fornavn' => $fornavn,
									':efternavn' => $efternavn,
									':fodselsdato' => $fodselsdato,
									':adresse' => $adresse,
									':postnr' => $postnr,
									':city' => $by,
									':tlf' => $tel,
									':omg' => $mail,
									':nice' => $adgangskode,
									':wtf' => 2
								))) {
									$error['brugeropret'] = 'Der skete en fejl ved oprettelse. SCRUB!';
								}
								else {
									//header('Location: ?p=login');
								}
						}
					}
					else {
						$error['generel'] = 1801; // execute fejl
					}
				}
				else {
					$error['generel'] = 1802; // prepare fejl
				}
			}
		}
		
	}
                                        //print_r(validTel('34 45 23 23'));
                                        //print_r(validTel($post['tlf']));
                                        //print_r($tel);

?>
</div>
<form action="" method="post" id="eventForm">
    <?php 
        if (isset($error['brugerfindes'])) echo '<div class="alert alert-danger">'.$error['brugerfindes'].'</div>'.PHP_EOL;
        if (isset($error['brugeropret'])) echo '<div class="alert alert-danger">'.$error['brugeropret'].'</div>'.PHP_EOL;
    ?>
    <?=secCreateTokenInput()?>
    <fieldset class="col-md-6">
        <legend>Profil:</legend>
        <div class="row">
        <div class="form-group col-md-6">
            <label for="fornavn">Fornavn</label><br />
            <input class="form-control input-md" type="text" name="fornavn"  id="fornavn" min="2" max="30"><br />
            <?php
                if (isset($error['fornavn'])) echo '<div class="alert alert-danger">'.$error['fornavn'].'</div>'.PHP_EOL;
            ?>
        </div>
        </div>
        <div class="row">
        <div class="form-group col-md-6">
            <label for="efternavn">Efternavn</label><br />
            <input class="form-control input-md" type="text" name="efternavn"  id="efternavn" min="2" max="30"><br />
            <?php
			if (isset($error['efternavn'])) echo '<div class="alert alert-danger">'.$error['efternavn'].'</div>'.PHP_EOL;
		?>
        </div>
        </div>
        <div class="row">
        <div class="form-group col-md-6">
            <label for="fodselsdato">Fødsesldato</label><br />
            <input class="form-control input-md" type="date" name="fodselsdato" id="fodselsdato"><br />
            <?php
			if (isset($error['fodselsdato'])) echo '<div class="alert alert-danger">'.$error['fodselsdato'].'</div>'.PHP_EOL;
		?>
        </div>
        </div>
        <div class="row">
        <div class="form-group col-md-6">
            <label for="adresse">Adresse</label><br />
            <input class="form-control input-md" type="text" name="adresse"  id="adresse" min="2" max="65"><br />
            <?php
			if (isset($error['adresse'])) echo '<div class="alert alert-danger">'.$error['adresse'].'</div>'.PHP_EOL;
		?>
        </div>
        </div>
        <div class="row">
        <div class="form-group col-md-6">
            <label for="postnr">Post nr.</label><br />
            <input class="form-control input-md" type="number" name="postnr"  id="postnr" min="0" max="99999"><br />
            <?php
			if (isset($error['postnr'])) echo '<div class="alert alert-danger">'.$error['postnr'].'</div>'.PHP_EOL;
		?>
        </div>
        </div>
        <div class="row">
        <div class="form-group col-md-6">
            <label for="city">By</label><br />
            <input class="form-control input-md" type="text" name="city"  id="city" min="2" max="30"><br />
            <?php
			if (isset($error['city'])) echo '<div class="alert alert-danger">'.$error['city'].'</div>'.PHP_EOL;
		?>
        </div>
        </div>
        <div class="row">
        <div class="form-group col-md-6">
            <label for="tlf">Tlf.</label><br />
            <input class="form-control input-md" type="text" name="tlf"  id="tlf"><br />
            <?php
			if (isset($error['tlf'])) echo '<div class="alert alert-danger">'.$error['tlf'].'</div>'.PHP_EOL;
		?>
        </div>
        </div>
    </fieldset>
    <fieldset class="col-md-6">
        <legend>Login oplysninger:</legend>
        <div class="row">
        <div class="form-group col-md-6">
            <label for="email">Email</label><br />
            <input class="form-control input-md" type="email" name="email"  id="email"><br />
            <?php
			if (isset($error['email'])) echo '<div class="alert alert-danger">'.$error['email'].'</div>'.PHP_EOL;
		?>
            
        </div>
        </div>
        <div class="row">
        <div class="form-group col-md-6">
            <label for="kode">Adgangskode</label><br />
            <input class="form-control input-md" type="password" name="kode"  id="kode"><br />
            
        </div>
        </div>
        <div class="row">
        <div class="form-group col-md-6">
            <label for="gentagKode">Gentag Adgangskode</label><br />
            <input class="form-control input-md" type="password" name="gentagKode"  id="gentagKode"><br /><br />
            <?php
			if (isset($error['kodematch'])) echo '<div class="alert alert-danger">'.$error['kodematch'].'</div>'.PHP_EOL;
			if (isset($error['kodeformat'])) echo '<div class="alert alert-danger">'.$error['kodeformat'].'</div>'.PHP_EOL;
		?>
        </div>
        </div>
    </fieldset>
        <button type="submit" class="btn btn-default col-md-10" name="opretBruger">Opret</button>
</form>
</div>