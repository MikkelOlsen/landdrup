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
        $navn            = validStringBetween($post['navn'], 2, 30) ? $post['navn']                 : $error['navn'] = 'Fejl i stilartens navn';
		$beskrivelse 	 = validMixedBetween($post['beskrivelse'], 1, 511) ? $post['beskrivelse'] 	: $error['beskrivelse'] = 'fejl besked beskrivelse!';
		if(sizeof($error) === 0){
			$billede = mediaImageUploader('filUpload');
			if($billede['code']){
				sqlQueryPrepared(
					"
						INSERT INTO `media`(`sti`, `type`) VALUES (:sti, :type);
						SELECT LAST_INSERT_ID() INTO @lastId;
						INSERT INTO `stilarter`(`beskrivelse`, `fk_media`, `navn`) VALUES (:beskrivelse, @lastId, :navn);
					",
					array(
						':sti' => $billede['name'],
						':type' => $billede['type'],
						':beskrivelse' => $beskrivelse,
                        ':navn' => $navn
					)
				);
				header('Location: ?p=visStil');
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
		<h1 class="center-align">Stilart</h1>
        <div class="input-field col s12">
            <label for="navn">Navn</label><br />
            <input class="validate" type="text" name="navn"  id="navn" min="2" max="30"><br />
        </div>
		<div class="input-field col s12">
		<textarea name="beskrivelse" class="materialize-textarea"></textarea>
		<label for="beskrivelse">Beskrivelse</label>
		</div>
		<div class="file-field input-field col s12">
			<div class="btn">
				<span>Billede</span>
				<input name="filUpload" type="file">
			</div>
			<div class="file-path-wrapper">
				<input class="file-path validate"  type="text">
			</div>
		<button name="opretStil" class="waves-effect waves-light btn" type="submit">Opret</button>
		</div>
</form>		
	</div>
</div>
