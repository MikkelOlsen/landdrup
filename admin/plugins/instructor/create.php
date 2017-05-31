<?php
	if(secCheckLevel() < 90){
		die();
	}
	if(secCheckMethod('POST')){
		$error   		= [];
		$post    		= secGetInputArray(INPUT_POST);
		$bruger 		= isset($post['bruger']) ? $post['bruger'] 									: $error['bruger'] 		= 'fejl besked bruger!';
		$beskrivelse 	= validMixedBetween($post['beskrivelse'], 1, 511) ? $post['beskrivelse'] 	: $error['beskrivelse'] = 'fejl besked beskrivelse!';
		if(sizeof($error) === 0){
			$billede = mediaImageUploader('filUpload');
			if($billede['code']){
				sqlQueryPrepared(
					"
						INSERT INTO `media`(`sti`, `type`) VALUES (:sti, :type);
						SELECT LAST_INSERT_ID() INTO @lastId;
						INSERT INTO `instruktor`(`beskrivelse`, `fk_media`, `fk_profil`) VALUES (:beskrivelse, @lastId, :fk_profil);
					",
					array(
						':sti' => $billede['name'],
						':type' => $billede['type'],
						':beskrivelse' => $beskrivelse,
						':fk_profil' => $bruger
					)
				);
				header('Location: ?p=opretInstruktor');
			} else {
				$error['filUpload'] = $billede['msg'];
			}
		}
	} else {
			$stmt = $conn->prepare("SELECT profil.id, profil.fornavn, profil.efternavn
									FROM profil
									INNER JOIN brugere
									ON brugere.fk_profil = profil.id
									INNER JOIN brugerroller
									ON brugere.fk_brugerrolle = brugerroller.id
									WHERE brugerroller.niveau >= 50 AND profil.id NOT IN (SELECT instruktor.fk_profil FROM instruktor)");
			$stmt->execute();
			$result = $stmt->setFetchMode(PDO::FETCH_OBJ); 
	}
?>

<div class="container">
	<div class="row">
		<form action="" method="post" class="col s12" enctype="multipart/form-data">
		<h1 class="center-align">Instruktør</h1>
		<div class="input-field col s12">
		<select name="bruger">
		<option value="" disabled selected>Choose your option</option>
			<?php foreach($stmt->fetchAll() as $value){
				echo '<option value="'.$value->id.'">'.$value->fornavn.' '.$value->efternavn.'</option>';
			}
				?>
		</select>
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
		<button name="opretInstruktor" class="waves-effect waves-light btn" type="submit">Opret</button>
		</div>
</form>		
	</div>
</div>
