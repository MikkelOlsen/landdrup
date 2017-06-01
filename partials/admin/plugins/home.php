<?php
    if($filter->checkMethod('GET') || $filter->checkMethod('POST')){
        $GET = $filter->sanitizeArray(INPUT_GET);
        if(isset($GET['view']) && !empty($GET['view'])){
            $viewPath = './plugins/' . $GET['view'] . '.php';      
            if(file_exists($viewPath)){
                $adminView = $viewPath;
            } else {
                header('Location: ./index.php?p=home&view=404');
            }
        } else {
            header('Location: ./index.php?p=home&view=404');
        }
    }
?>
<div class="row">
    <div class="col m3 l3 hide-on-med-and-down">
        <ul id="slideMenu" class="adminMenu z-depth-4">
            <li>
                <div class="userView">
                    <div class="background teal">
                        <!--<img src="http://placehold.it/300x200">-->
                    </div>
                    
                    <a href="#!user"><img class="circle" src="http://placehold.it/80x80"></a>
                    <a href="#!name"><span class="white-text name"><?=$_SESSION['userFullname']?></span></a>
                    <a href="#!email"><span class="white-text email"><?=$_SESSION['userEmail']?></span></a>
                       
                </div>
            </li>
            <li><a class="waves-effect z-depth-1" href="./index.php?p=home"><i class="material-icons">home</i>Oversigt</a></li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header">Brugere<i class="material-icons">arrow_drop_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="./index.php?p=home&view=Users/List">Liste</a></li>
                                <li><a href="./index.php?p=home&view=Users/Create">Opret</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header">Instruktører<i class="material-icons">arrow_drop_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="./index.php?p=home&view=Instructors/List">Liste</a></li>
                                <li><a href="./index.php?p=home&view=Instructors/Create">Opret</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header">Stilarter<i class="material-icons">arrow_drop_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#!">Liste</a></li>
                                <li><a href="#!">Opret</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header">Hold<i class="material-icons">arrow_drop_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#!">Liste</a></li>
                                <li><a href="#!">Opret</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header">Niveauer<i class="material-icons">arrow_drop_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#!">Liste</a></li>
                                <li><a href="#!">Opret</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header">Aldersgrupper<i class="material-icons">arrow_drop_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#!">Liste</a></li>
                                <li><a href="#!">Opret</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header">Sider<i class="material-icons">arrow_drop_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="./index.php?p=home&view=Pages/Edit&url=home">Forside</a></li>
                                <li><a href="#!">Instruktører</a></li>
                                <li><a href="#!">Stilarter</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="col m12 l9">
        <h2>Admin kontrolpanel</h2>
        <div>
        <?php include $adminView; ?>
        </div>
        <ul id="slide-out" class="side-nav">
            <li>
                <div class="userView">
                    <div class="background teal">
                        <!--<img src="http://placehold.it/300x200">-->
                    </div>
                    
                    <a href="#!user"><img class="circle" src="http://placehold.it/80x80"></a>
                    <a href="#!name"><span class="white-text name"><?=$_SESSION['userFullname']?></span></a>
                    <a href="#!email"><span class="white-text email"><?=$_SESSION['userEmail']?></span></a>
                        
                </div>
            </li>
            <li><a class="waves-effect" href="./index.php?p=home"><i class="material-icons">home</i>Oversigt</a></li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header">Brugere<i class="material-icons">arrow_drop_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#!">Liste</a></li>
                                <li><a href="#!">Opret</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header">Instruktører<i class="material-icons">arrow_drop_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#!">Liste</a></li>
                                <li><a href="#!">Opret</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header">Stilarter<i class="material-icons">arrow_drop_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#!">Liste</a></li>
                                <li><a href="#!">Opret</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header">Hold<i class="material-icons">arrow_drop_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#!">Liste</a></li>
                                <li><a href="#!">Opret</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header">Niveauer<i class="material-icons">arrow_drop_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#!">Liste</a></li>
                                <li><a href="#!">Opret</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header">Aldersgrupper<i class="material-icons">arrow_drop_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#!">Liste</a></li>
                                <li><a href="#!">Opret</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header">Sider<i class="material-icons">arrow_drop_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#!">Forside</a></li>
                                <li><a href="#!">Instruktører</a></li>
                                <li><a href="#!">Stilarter</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
        <a href="#" data-activates="slide-out" class="btn button-collapse hide-on-large-only"><i class="material-icons">menu</i>Admin menu</a>
    </div>
</div>

