<?php
	if(secCheckLevel() < 50){
		die();
	}
    $error = [];
    $inst = instGet($get['id']);
	if(secCheckMethod('POST')){
        $post = secGetInputArray(INPUT_POST);
        if(!secValidateToken($post['_once'], 600)) {
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }
		$error   		= [];
		$post    		= secGetInputArray(INPUT_POST);
		$beskrivelse 	= validMixedBetween($post['beskrivelse'], 1, 511) ? $post['beskrivelse'] 	: $error['beskrivelse'] = 'fejl besked beskrivelse!';
		if(sizeof($error) === 0){
            if(!empty($_FILES['filUpload']['name'])) {
			$billede = mediaImageUploader('filUpload');
			if($billede['code']){
                $collect = getImage($get['id']);
                $imgID = $collect['id'];
                $img = $conn->prepare("SELECT sti, media.id AS medId
                       FROM media 
                       INNER JOIN instruktor 
                       ON media.id = instruktor.fk_media 
                       WHERE instruktor.fk_profil = :id");
                $img->bindParam(':id', $get['id'], PDO::PARAM_INT);
                $img->execute();

                $media = $img->fetch(PDO::FETCH_OBJ);

                $image = $media->medId;
                $sti = './../media/'.$media->sti;
				if(sqlQueryPrepared(
					"
						UPDATE `media` SET `sti` = :sti WHERE id = :mediaID;
						UPDATE `instruktor` SET `beskrivelse` = :beskrivelse WHERE fk_profil = :profID
					",
					array(
                        ':mediaID' => $imgID,
						':sti' => $billede['name'],
						':beskrivelse' => $beskrivelse,
						':profID' => $get['id']
					)
				)) {
                unlink($sti);
				header('Location: ?p=visInstruktor');
                }
			} else {
				$error['filUpload'] = $billede['msg'];
			}
		} else {
            sqlQueryPrepared(
                "
                   UPDATE `instruktor` SET `beskrivelse` = :beskrivelse WHERE fk_profil = :profID
                ",
                array(
                    ':beskrivelse' => $beskrivelse,
                    ':profID' => $get['id']                
                    )
            );
        }
        } 
	} 
    print_r($error);
?>

<div class="container">
	<div class="row">
		<form action="" method="post" class="col s12" enctype="multipart/form-data">
        <?=secCreateTokenInput()?>
		<h1 class="center-align">Instruktør</h1>
		<div class="input-field col s12">
		<textarea name="beskrivelse" class="materialize-textarea"><?php echo $inst['beskrivelse']?></textarea>
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
		<button name="opdaterInstruktor" class="waves-effect waves-light btn" type="submit">Opret</button>
		</div>
</form>		
	</div>
</div>
