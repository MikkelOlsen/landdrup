<?php
if(!secIsLoggedIn()) {
        header('Location: ?p=login');
        //die();
    }
    $stmt = $conn->prepare("SELECT instruktor.id AS instID, instruktor.beskrivelse, profil.fornavn, profil.efternavn, profil.tlf, profil.id AS profID, media.sti, brugere.email
                        FROM instruktor
                        INNER JOIN profil 
                        ON instruktor.fk_profil = profil.id
                        INNER JOIN media
                        ON instruktor.fk_media = media.id
                        INNER JOIN brugere
                        ON brugere.fk_profil = profil.id
                        ORDER BY profil.fornavn ASC");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_OBJ);
?>

<div class="container">
      <table class="highlight">
        <thead>
          <tr>
              <th></th>
              <th>Navn</th>
              <th>Tlf.</th>
              <th>Beskrivelse</th>
              <th>Email</th>
              <th></th>
              <th></th>
          </tr>
        </thead>

        <tbody>
          <?php
            foreach($stmt->fetchAll() as $value) {
                echo '<tr>
                        <td><img class="instImg" src="./../media/'.$value->sti.'" alt=""></td>
                        <td>'.$value->fornavn.' '.$value->efternavn.'</td>
                        <td>'.$value->tlf.'</td>
                        <td>'.$value->beskrivelse.'</td>
                        <td>'.$value->email.'</td>
                        <td><a href="#" class="red-text" data-target="modal'.$value->instID.'"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        <td><a class="" href="?p=redigerInst&id='.$value->profID.'"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                      </tr>';

                echo '
                        <!-- Modal Structure -->
                        <div id="modal'.$value->instID.'" class="modal">
                            <div class="modal-content">
                            <h4>Sikker?</h4>
                            <p>Er du sikker på at du vil fjerne <b>'.$value->fornavn.' '.$value->efternavn.'</b> som instruktør?</p>
                            </div>
                            <div class="modal-footer">
                            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Nej</a>
                            <a href="?p=deleteInst&id='.$value->instID.'" class="modal-action modal-close waves-effect waves-green btn-flat">Ja</a>
                            </div>
                        </div>';
            }
          ?>
        </tbody>
      </table>
</div>

<script>
    
  $(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
  });
</script>

