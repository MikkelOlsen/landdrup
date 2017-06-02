<?php
if(!secIsLoggedIn()) {
        header('Location: ?p=login');
        //die();
    }
if(isset($get['id']) && !empty($get['id'])){
    if(secCheckLevel() >= 90) {
        $profileId = $get['id'];
    } else {
        header('Location: ?p=visInstruktor');
        exit;
    }
}else{
    echo 'fejl i id get';
    header('Location: ?p=visInstruktor');
    exit;
}

$img = $conn->prepare("SELECT sti, media.id AS medId
                       FROM media 
                       INNER JOIN instruktor 
                       ON media.id = instruktor.fk_media 
                       WHERE instruktor.id = :id");
$img->bindParam(':id', $profileId, PDO::PARAM_INT);
$img->execute();

$media = $img->fetch(PDO::FETCH_OBJ);

$image = $media->medId;
$sti = './../media/'.$media->sti;

echo $image;

if(sqlQueryPrepared("DELETE FROM instruktor WHERE id = :id", array(':id' => $profileId))) {
        if(sqlQueryPrepared("DELETE FROM media WHERE id = :id", array(':id' => $image))){
            echo 'gik i stå';
            if(file_exists($sti)) {
                unlink($sti);
                echo 'success!';
            } else {
                echo 'Naaah';
            }
        } else {
            echo 'nope';
        }
    header('Location: ?p=visInstruktor');
} else {
    echo 'Der skete en fejl ved slettelsen af instruktøren, prøv igen.';
}