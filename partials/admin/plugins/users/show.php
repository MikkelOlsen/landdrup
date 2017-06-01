<?php
    $stmt = $conn->prepare("SELECT profil.id, profil.fornavn, profil.efternavn, profil.tlf, brugere.email
                        FROM profil
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
              <th>Navn</th>
              <th>Tlf.</th>
              <th>Email</th>
              <th></th>
              <th></th>
          </tr>
        </thead>

        <tbody>
          <?php
            foreach($stmt->fetchAll() as $value) {
                echo '<tr>
                        <td>'.$value->fornavn.' '.$value->efternavn.'</td>
                        <td>'.$value->tlf.'</td>
                        <td>'.$value->email.'</td>
                        <td><a class="red-text" data-target="modal'.$value->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        <td><a class="grey-text text-lighten-2"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                      </tr>';

                echo '
                        <!-- Modal Structure -->
                        <div id="modal'.$value->id.'" class="modal">
                            <div class="modal-content">
                            <h4>Sikker?</h4>
                            <p>Er du sikker på at du vil fjerne <b>'.$value->fornavn.' '.$value->efternavn.'</b> som instruktør?</p>
                            </div>
                            <div class="modal-footer">
                            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Nej</a>
                            <a href="?p=deleteUser&userid='.$value->id.'" class="modal-action modal-close waves-effect waves-green btn-flat">Ja</a>
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

