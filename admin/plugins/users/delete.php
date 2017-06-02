<?php
if(!secIsLoggedIn()) {
        header('Location: ?p=login');
        //die();
    }
if(isset($get['userid']) && !empty($get['userid'])){
    if(secCheckLevel() >= 90) {
        $profileId = $get['userid'];
    } else {
        header('Location: ?p=visBruger');
        exit;
    }
}else{
    echo 'fejl i id get';
    header('Location: ?p=visBruger');
    exit;
}

if(sqlQueryPrepared("DELETE FROM brugere WHERE fk_profil = :id;
                     DELETE FROM profil WHERE id = :id", array(':id' => $profileId)) {
    header('Location: ?p=visBruger');
} else {
    echo 'Der skete en fejl ved slettelsen af instruktøren, prøv igen.';
}