<ul id="slide-out" class="side-nav">
    <li><div class="userView">
      <div class="background">
        <img src="./assets/img/cover.jpg" style="height:176px; width:300px;" alt="Dispute Bills">
      </div>
      <a href="?p=profil"><img src="./assets/img/dummy_350x350.png" alt="user" class="circle"></a>
      <a href="?p=profil"><span class="white-text name"><?= $user['fornavn'] .' '. $user['efternavn']?></span></a>
      <a href="?p=profil"><span class="white-text email"><?= $user['email']?></span></a>
    </div></li>
    <li><a class="waves-effect" href="?p=profil"><i class="fa fa-user-o" aria-hidden="true"></i>Profil</a></li>
    <li><a class="waves-effect" href="?p=settings"><i class="fa fa-cog" aria-hidden="true"></i>Indstillinger</a></li>
   
    <li><div class="divider"></div></li>
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Instruktør<i class="fa fa-chevron-down" aria-hidden="true"></i></a>
            <div class="collapsible-body">
              <ul>
              <li><a href="?p=visInstruktor">Liste</a></li>
                <?php
                  if($user['niveau'] >= 90) {
                    echo '<li><a href="?p=opretInstruktor">Opret Intruktør</a></li>';
                  }
                ?>
              </ul>
            </div>
          </li>
        </ul>
      </li>
    
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Brugere<i class="fa fa-chevron-down" aria-hidden="true"></i></a>
            <div class="collapsible-body">
              <ul>
              <li><a href="?p=visBruger">Liste</a></li>
                <?php
                  if($user['niveau'] >= 90) {
                    echo '<li><a href="?p=opretBruger">Opret Bruger</a></li>';
                  }
                ?>
              </ul>
            </div>
          </li>
        </ul>
      </li>
      <li><div class="divider"></div></li>
       <li><a class="waves-effect bottom" href="?p=logout"><i class="fa fa-sign-out" aria-hidden="true"></i>Log ud</a></li>
  </ul>
