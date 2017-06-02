<?php
if(!secIsLoggedIn()) {
        header('Location: ?p=login');
        //die();
    }
	if(secCheckLevel() < 90){
		die();
	}
	$error=[];
	if(secCheckMethod('POST')){
		$post = secGetInputArray(INPUT_POST);
		if(!secValidateToken($post['_once'], 600)) {
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }
		$error   		 = [];
		$post    		 = secGetInputArray(INPUT_POST);
        $navn            = validStringBetween($post['navn'], 2, 10) ? $post['navn'] : $error['navn'] = 'Fejl i stilartens navn';
		if(sizeof($error) === 0){
				if(sqlQueryPrepared(
					"
						INSERT INTO `aldersgrupper`(`navn`) VALUES (:navn);
					",
					array(
                        ':navn' => $navn
					)
				)) {
				header('Location: ?p=visAlder');
			} else {
				$error['filUpload'] = $billede['msg'];
			}
		}
	} 
    //print_r($error);
?>

<div class="container">
	<div class="row">
		<form action="" method="post" class="col s12" enctype="multipart/form-data">
		<?=secCreateTokenInput()?>
		<h1 class="center-align">Aldersgruppe</h1>
        <div class="input-field col s12">
            <label for="navn">Navn</label><br />
            <input class="validate" type="text" name="navn"  id="navn" min="2" max="10"><br />
        </div>
		<button name="opretStil" class="waves-effect waves-light btn" type="submit">Opret</button>
		</div>
</form>		
	</div>
</div>
