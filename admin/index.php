<?php
    ob_start();
    require_once './sqlconfig.php';
    require_once '../lib/sqlOperations.php';
    require_once '../lib/validate.php';
    require_once '../lib/security.php';
    require_once '../lib/user.php';
    require_once '../lib/media.php';
    if(!secIsLoggedIn()) {
        header('Location: ?p=login');
        //die();
    }
        $user = userGet($_SESSION['userid']);

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
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
  <!-- Include jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>

</head>
<body>


<?php
    if(isset($_SESSION['userid']) && secCheckLevel() > 50) {
        include_once './includes/header.php';
    }
?>
<main>
<nav>
    <div class="nav-wrapper main-nav">
      <a href="#" class="brand-logo"><h3>Landdrup Dans</h3></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="?p=profil">Profil</a></li>
        <li><a href="badges.html">Components</a></li>
        <?php if(!secIsLoggedIn()) {echo '<li><a href="?p=login">Log ind</a></li>';}
                else {echo '<li><a class="dropdown-button" href="#!" data-activates="dropdown1">Menu<i class="material-icons right">arrow_drop_down</i></a></li>
                                <ul id="dropdown1" class="dropdown-content">
                                    <li><a href="#!">Min profil</a></li>
                                    <li class="divider"></li>
                                    <li><a href="?p=logout">Log af</a></li>
                                </ul>';} ?>
      </ul>
    </div>
  </nav>
  
    <?php
        if(secCheckMethod('GET') || secCheckMethod('POST')) {
            $get = secGetInputArray(INPUT_GET);
            if(isset($get['p']) && !empty($get['p'])) {
                switch ($get['p']) {


                    // OVERALL CASES
                    case 'login' :
                        include_once './plugins/users/login.php';
                        break;
                    case 'logout';
                        include_once './plugins/users/logout.php';
                        break;


                    // USER CASES
                    case 'visBruger';
                        include_once './plugins/users/show.php';
                        break;
                    case 'opretBruger' : 
                        include_once './plugins/users/create.php';
                        break;
                    case 'profil' : 
                        include_once './plugins/users/profil.php';
                        break;
                    case 'settings';
                        include_once './plugins/users/settings.php';
                        break; 
                    case 'deleteUser';
                        include_once './plugins/users/delete.php';
                        break;
                    case 'editUser';
                        include_once './plugins/users/edit.php';
                        break;


                    // INSTRUCTOR CASES 
                    case 'visInstruktor';
                        include_once './plugins/instructor/show.php';
                        break;
                    case 'opretInstruktor':
						include_once './plugins/instructor/create.php';
						break;
                    case 'deleteInst';
                        include_once './plugins/instructor/delete.php';
                        break;
                    case 'redigerInst';
                        include_once './plugins/instructor/edit.php';
                        break;
                    

                    // STYLE CASES
                    case 'opretStil';
                        include_once './plugins/stilarter/create.php';
                        break;
                    case 'visStil';
                        include_once './plugins/stilarter/show.php';
                        break;
                    case 'deleteStil';
                        include_once './plugins/stilarter/delete.php';
                        break;
                    case 'redigerStil';
                        include_once './plugins/stilarter/edit.php';
                        break;

                    // LEVEL CASES
                    case 'opretNiveau';
                        include_once './plugins/niveau/create.php';
                        break;
                    case 'visNiveau';
                        include_once './plugins/niveau/show.php';
                        break;
                    case 'redigerNiveau';
                        include_once './plugins/niveau/edit.php';
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
    
$(".dropdown-button").dropdown();
        
  });
            
  </script>
  
</main>
    <?php
        include_once './includes/footer.php';
    ?>
</body>
</html>
