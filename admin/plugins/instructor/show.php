<?php
    $stmt = $conn->prepare("SELECT instruktor.id, instruktor.beskrivelse, profil.fornavn, profil.efternavn, profil.tlf, media.sti, brugere.email
                        FROM instruktor
                        INNER JOIN profil 
                        ON instruktor.fk_profil = profil.id
                        INNER JOIN media
                        ON instruktor.fk_media = media.id
                        INNER JOIN brugere
                        ON brugere.fk_profil = profil.id");
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
                        <td><a class="red-text" href="?p=deleteInst&id='.$value->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        <td><i class="fa fa-pencil" aria-hidden="true"></i></td>
                      </tr>';
            }
          ?>
        </tbody>
      </table>
</div>