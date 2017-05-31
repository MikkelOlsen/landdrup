<?php
  if(secCheckMethod('POST')) {
        $post = secGetInputArray(INPUT_POST);
        $error = [];

        if(!secValidateToken($post['_once'], 600)) {
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }

    if(isset($post['opdaterBruger'])) {
        $test = 'started';
            if(!empty($post['kode'] && $post['gentagKode'])) 
            {
            $mail        = validEmail($post['email']) ? $post['email']                   : $error['email']       = 'Email skal udfyldes og være en gyldig email adresse.';
            $adgangskode = validMatch($post['gentagKode'], $post['kode']) ? $post['kode']: $error['kodematch']   = 'Dine kodeord matcher ikke.';
            $adgangskode = validMixedBetween($post['kode'], 4) ? $post['kode']           : $error['kodeformat']  = 'Din kode er ikke lang nok.';
            if(sizeof($error) === 0){
				if ($stmt = $conn->prepare("SELECT id FROM brugere WHERE email = :mail")) {
					$stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
					if ($stmt->execute()) { 
						if ($stmt->rowCount() > 0 && $mail !== $_SESSION['username']) {
                            $test = 'fejl';
							$error['brugerfindes'] = 'Den email, du prøver at bruge, ekstisterer allerede.';
						}
						else {
                            $adgangskode = password_hash($adgangskode, PASSWORD_BCRYPT, ['cost' => 12]);
                            $test = 'hashed';
							if (!sqlQueryPrepared('
								UPDATE `brugere` SET `email` = :email, `password` = :password WHERE id = :id
								',array(
									':email' => $mail,
									':password' => $adgangskode,
                                    ':id' => $_SESSION['userid']
								))) {
                                    $test = 'fail';
									$error['brugeropret'] = 'Der skete en fejl ved opdateringen.';
								}
								else {
									header('Location: ?p=logout');
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
            } else if(empty($post['kode'] && $post['gentagKode'])) {
                $mail = validEmail($post['email']) ? $post['email'] : $error['email'] = 'Email skal udfyldes og være en gyldig email adresse.';
                if(sizeof($error) === 0) {
                    if($stmt = $conn->prepare("SELECT id FROM brugere WHERE email = :mail")) {
                        $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
                        if($stmt->execute()) {
                            if ($stmt->rowCount() > 0) {
							$error['brugerfindes'] = 'Den email, du prøver at bruge, ekstisterer allerede.';
						}
						else {
							if (!sqlQueryPrepared('
								UPDATE `brugere` SET `email` = :email WHERE id = :id
								',array(
									':email' => $mail,
                                    ':id' => $_SESSION['userid']
								))) {
									$error['brugeropret'] = 'Der skete en fejl ved opdateringen.';
								}
								else {
                                    $_SESSION['username'] = $mail;
									header('Location: ?p=settings');
								}
						}
                        }
                    }
                }
            }
        }
  }
?>

<div class="container">
<div class="row">
    
<h1 class="center-align"><b>Indstillinger</b></h1>


<form class="col s6" action="" method="post" id="eventForm">
    <?php 
   
        if (isset($error['brugerfindes'])) echo '<div class="alert alert-danger">'.$error['brugerfindes'].'</div>'.PHP_EOL;
        if (isset($error['brugeropret'])) echo '<div class="alert alert-danger">'.$error['brugeropret'].'</div>'.PHP_EOL;
    ?>
    <?=secCreateTokenInput()?>
        <div class="row">
        <div class="input-field col s12">
            <label for="email">Email</label><br />
            <input class="validate" type="email" name="email" id="email" value="<?= $user['email'] ?>"><br />
            <?php
                if (isset($error['email'])) echo '<div class="alert alert-danger">'.$error['email'].'</div>'.PHP_EOL;
            ?>
        </div>
        </div>
        <div class="row">
        <div class="input-field col s12">
            <label for="kode">Adgangskode</label><br />
            <input class="validate" type="password" name="kode"  id="kode"><br />
            <?php
			if (isset($error['kodeformat'])) echo '<div class="alert alert-danger">'.$error['kodeformat'].'</div>'.PHP_EOL;
		?>
        </div>
        </div>
        <div class="row">
        <div class="input-field col s12">
            <label for="gentagKode">Gentag adgangskode</label><br />
            <input class="validate" type="password" name="gentagKode" id="gentagKode"><br />
            <?php
			if (isset($error['kodematch'])) echo '<div class="alert alert-danger">'.$error['kodematch'].'</div>'.PHP_EOL;
		?>
        </div>
        </div>
    <input type="submit" class="btn btn-default col-md-3" name="opdaterBruger" value="submit">
</form>