<?php
    if(!secIsLoggedIn()) {
        header('Location: ?p=login');
        //die();
    }
?>