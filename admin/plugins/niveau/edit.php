<?php
if(!secIsLoggedIn()) {
        header('Location: ?p=login');
        //die();
    }
	if(secCheckLevel() < 50){
		die();
	}
    $error = [];
    $collect = getFromDB("SELECT navn FROM niveau WHERE id = :id", $get['id']);
	if(secCheckMethod('POST')){
        $post = secGetInputArray(INPUT_POST);
        if(!secValidateToken($post['_once'], 600)) {
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }
		$error   		= [];
        $navn            = validStringBetween($post['navn'], 2, 30) ? $post['navn']                 : $error['navn'] = 'Fejl i stilartens navn';
		if(sizeof($error) === 0){
			if(sqlQueryPrepared(
					"
						UPDATE `niveau` SET `navn` = :navn WHERE id = :id
					",
					array(
                        ':navn' => $navn,
						':id' => $get['id']
					)
				)) {
                    header('Location: ?p=visNiveau');
                } else {
                    $error['SQL'] = 'Fejl i rettelse af niveau, prøv igen.';
                }
        }
	}
    //print_r($error);
    //print_r($inst);
?>

<div class="container">
	<div class="row">
		<form action="" method="post" class="col s12" enctype="multipart/form-data">
		<?=secCreateTokenInput()?>
		<h1 class="center-align">Stilart</h1>
        <div class="input-field col s12">
            <label for="navn">Navn</label><br />
            <input class="validate" type="text" name="navn"  id="navn" min="2" max="30" value="<?php echo $collect['navn'] ?>"><br />
        </div>
		<button name="opdaterStil" class="waves-effect waves-light btn" type="submit">Opret</button>
		</div>
</form>		
	</div>
</div>
