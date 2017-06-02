<?php
if(!secIsLoggedIn()) {
        header('Location: ?p=login');
        //die();
    }
    $stmt = $conn->prepare("SELECT navn, id, niveau
                            FROM brugerroller
                            WHERE niveau != 99");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_OBJ);

    $profile = getFromDB("SELECT brugerroller.niveau, brugere.id, brugere.email, brugere.fk_brugerrolle, profil.fornavn, profil.efternavn, DATE_FORMAT(profil.fodselsdato, '%d %M %Y') AS dateCreated, profil.adresse, profil.postnr, profil.tlf, profil.city 
                                  FROM brugere 
                                  INNER JOIN profil 
                                  ON brugere.fk_profil = profil.id
                                  INNER JOIN brugerroller
                                  ON brugere.fk_brugerrolle = brugerroller.id
                                  WHERE profil.id = :id", $get['userid']);
    

    $error = [];
    if(secCheckMethod('POST')){

      $post = secGetInputArray(INPUT_POST);

        if(!secValidateToken($post['_once'], 600)) {
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }

        if(isset($post['opdaterBruger'])) {
          $error=[];
          $brugerrolle = isset($post['rolle']) ? $post['rolle'] : $error['rolle'] = 'Der er fejl i værdien på rollen du har valgt.';

          if(sizeof($error) === 0) {
            if(!sqlQueryPrepared('
                UPDATE brugere SET fk_brugerrolle = :rolle WHERE fk_profil = :id
            ', array(
                ':rolle' => $brugerrolle,
                ':id' => $get['userid']
            ))){
              $error['oprettelse'] = 'Der skete en fejl ved opdateringen af brugerens rolle.';
            } else {
              header('Location: ?p=visBruger');
            }
          }
        }
    }
    //print_r($error);
    //sprint_r($profile);
?>




<div class="container">
<?php echo '<h2>Rediger bruger - '.$profile['fornavn'] . ' ' . $profile['efternavn'].'</h2>'; ?>
<div class="row">
     <form action="" method="post" class="col s8" enctype="multipart/form-data">
     <?= secCreateTokenInput() ?>
         <div class="input-field col s8">
          <select name="rolle">
            <?php
              foreach($stmt->fetchAll() as $value) {
                $selected = '';
                if($value->id === $profile['fk_brugerrolle']) {
                  $selected = 'selected';
                }
                echo '<option value="'.$value->id.'" '.$selected.'>'.$value->navn.'</option>';
              }
            ?>
          </select>
          <label>Bruger Rolle</label>
        </div>
</div>
        <input type="submit" class="btn btn-default col-md-3" name="opdaterBruger" value="submit">
     </form>

</div>

