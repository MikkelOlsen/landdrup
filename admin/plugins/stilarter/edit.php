<?php
if(!secIsLoggedIn()) {
        header('Location: ?p=login');
        //die();
    }
	if(secCheckLevel() < 50){
		die();
	}
    $error = [];
    $inst = getFromDB("SELECT navn, beskrivelse FROM stilarter WHERE id = :id", $get['id']);
	if(secCheckMethod('POST')){
        $post = secGetInputArray(INPUT_POST);
        if(!secValidateToken($post['_once'], 600)) {
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }
		$error   		= [];
        $navn            = validStringBetween($post['navn'], 2, 30) ? $post['navn']                 : $error['navn'] = 'Fejl i stilartens navn';-
		$beskrivelse 	= validMixedBetween($post['beskrivelse'], 1, 511) ? $post['beskrivelse'] 	: $error['beskrivelse'] = 'fejl besked beskrivelse!';
		if(sizeof($error) === 0){
            if(!empty($_FILES['filUpload']['name'])) {
			$billede = mediaImageUploader('filUpload');
			if($billede['code']){
                $collect = getFromDB("SELECT media.sti, media.id
                                    FROM media
                                    INNER JOIN stilarter
                                    ON media.id = stilarter.fk_media
                                    WHERE stilarter.id = :id", $get['id']);
                $imgID = $collect['id'];
                $img = $conn->prepare("SELECT sti, media.id AS medId
                       FROM media 
                       INNER JOIN stilarter 
                       ON media.id = stilarter.fk_media 
                       WHERE stilarter.id = :id");
                $img->bindParam(':id', $get['id'], PDO::PARAM_INT);
                $img->execute();

                $media = $img->fetch(PDO::FETCH_OBJ);

                $image = $media->medId;
                $sti = './../media/'.$media->sti;
				if(sqlQueryPrepared(
					"
						UPDATE `media` SET `sti` = :sti WHERE id = :mediaID;
						UPDATE `stilarter` SET `beskrivelse` = :beskrivelse, `navn` = :navn WHERE id = :id
					",
					array(
                        ':mediaID' => $imgID,
						':sti' => $billede['name'],
						':beskrivelse' => $beskrivelse,
                        ':navn' => $navn,
						':id' => $get['id']
					)
				)) {
                unlink($sti);
				header('Location: ?p=visStil');
                }
			} else {
				$error['filUpload'] = $billede['msg'];
			}
		} else {
            sqlQueryPrepared(
                "
                   UPDATE `stilarter` SET `beskrivelse` = :beskrivelse, `navn` = :navn WHERE id = :id
                ",
                array(
                    ':beskrivelse' => $beskrivelse,
                    ':navn' => $navn,
                    ':id' => $get['id']                
                    )
            );
            header('Location: ?p=visStil');
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
            <input class="validate" type="text" name="navn"  id="navn" min="2" max="30" value="<?php echo $inst['navn'] ?>"><br />
        </div>
		<div class="input-field col s12">
		<textarea name="beskrivelse" class="materialize-textarea"><?php echo $inst['beskrivelse'] ?></textarea>
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
		<button name="opdaterStil" class="waves-effect waves-light btn" type="submit">Opret</button>
		</div>
</form>		
	</div>
</div>
