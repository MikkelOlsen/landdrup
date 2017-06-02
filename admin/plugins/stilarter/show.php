<?php
if(!secIsLoggedIn()) {
        header('Location: ?p=login');
        //die();
    }
    $stmt = $conn->prepare("SELECT stilarter.navn, stilarter.id, stilarter.beskrivelse, media.sti
                        FROM stilarter
                        INNER JOIN media
                        ON stilarter.fk_media = media.id
                        ORDER BY stilarter.navn ASC");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_OBJ);
?>

<div class="container">
      <table class="highlight">
        <thead>
          <tr>
              <th></th>
              <th>Navn</th>
              <th>Beskrivelse</th>
              <th></th>
              <th></th>
          </tr>
        </thead>

        <tbody>
          <?php
            foreach($stmt->fetchAll() as $value) {
                echo '<tr>
                        <td><img class="instImg" src="./../media/'.$value->sti.'" alt=""></td>
                        <td>'.$value->navn.'</td>
                        <td>'.$value->beskrivelse.'</td>
                        <td><a href="#" class="red-text" data-target="modal'.$value->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        <td><a class="" href="?p=redigerStil&id='.$value->id.'"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                      </tr>';

                echo '
                        <!-- Modal Structure -->
                        <div id="modal'.$value->id.'" class="modal">
                            <div class="modal-content">
                            <h4>Sikker?</h4>
                            <p>Er du sikker på at du vil fjerne stilarten <b>'.$value->navn.'</b> ?</p>
                            </div>
                            <div class="modal-footer">
                            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Nej</a>
                            <a href="?p=deleteStil&id='.$value->id.'" class="modal-action modal-close waves-effect waves-green btn-flat">Ja</a>
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

