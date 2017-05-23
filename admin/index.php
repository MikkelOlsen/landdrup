<?php

    require_once './sqlconfig.php';
    require_once '../lib/sqlOperations.php';
    require_once '../lib/validate.php';
    require_once '../lib/security.php';
    require_once '../lib/user.php';
    require_once '../lib/media.php';
    if(!secIsLoggedIn()) {
        //header('Location: ?p=login');
        //die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/style/mystyle.css">

</head>
<div class="background-cover">
<body>
<?php
    include './includes/header.php';
?>
<div class="container static-background">
    <?php
        if(secCheckMethod('GET') || secCheckMethod('POST')) {
            $get = secGetInputArray(INPUT_GET);
            if(isset($get['p']) && !empty($get['p'])) {
                switch ($get['p']) {
                    case 'opretBruger' : 
                        include_once './plugins/users/create.php';
                        break;
                    case 'login' :
                        include_once './plugins/users/login.php';
                        break;
                    case 'profil' : 
                        include_once './plugins/users/profil.php';
                        break;
                    case 'opretInstruktor':
						include_once './plugins/instructor/create.php';
						break;
                    default: 
                        echo '<h2>Velkommen til admin delen.</h2>'.PHP_EOL;
                        break;
                }
            }
            else {
            echo '<h2>Velkommen til admin delen.</h2>'.PHP_EOL;
            }
        }
    ?>
    </diV>
</body>
</div>
</html>
<!-- Include jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
