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
        $user = userGet();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
<!-- Latest compiled and minified CSS -->
 <!-- Compiled and minified CSS -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
  <link rel="stylesheet" href="./assets/style/mystyle.css">
  <?php if(isset($_SESSION['userid'])){echo '<link rel="stylesheet" href="./assets/style/loggedin.css">';} ?>
  <!-- Include jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>

</head>
<body>


<?php
    if(isset($_SESSION['userid'])) {
        include_once './includes/header.php';
    }
?>
<main>
<nav>
    <div class="nav-wrapper">
      <a href="#" class="brand-logo"><img src="./assets/img/brands_placeholder.png" alt=""></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="?p=profil">Profil</a></li>
        <li><a href="badges.html">Components</a></li>
        <li><a href="collapsible.html">JavaScript</a></li>
      </ul>
    </div>
  </nav>
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
                    case 'logout';
                        include_once './plugins/users/logout.php';
                        break;
                    case 'settings';
                        include_once './plugins/users/settings.php';
                        break;  
                    case 'visInstruktor';
                        include_once './plugins/instructor/show.php';
                        break;
                    case 'deleteInst';
                        include_once './plugins/instructor/delete.php';
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

                <div class="fixed-action-btn">
                    <a href="#" data-activates="slide-out" class="button-collapse btn-floating btn-large waves-effect waves-light red">
                        <i class="fa fa-bars" style="font-size:30px;" aria-hidden="true"></i>
                    </a>
                </div>

  <script>

      
  $(document).ready(function() {
    $('select').material_select();
    $(".button-collapse").sideNav();
  });
            
  </script>
  
</main>
    <?php
        include_once './includes/footer.php';
    ?>
</body>
</html>
