<?php
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

if(deleteUserById($profileId)) {
    header('Location: ?p=visBruger');
} else {
    echo 'Der skete en fejl ved slettelsen af instruktøren, prøv igen.';
}