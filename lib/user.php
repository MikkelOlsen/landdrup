<?php



function userGet() {
    global $conn;
     $stmt = $conn->prepare("SELECT brugerroller.niveau, brugere.email, profil.fornavn, profil.efternavn, DATE_FORMAT(profil.fodselsdato, '%d %M %Y') AS dateCreated, profil.adresse, profil.postnr, profil.tlf, profil.city 
                             FROM brugere 
                             INNER JOIN profil 
                             ON brugere.fk_profil = profil.id
                             INNER JOIN brugerroller
                             ON brugere.fk_brugerrolle = brugerroller.id
                             WHERE brugere.id = :id");
                $stmt->bindParam(':id', $_SESSION['userid'], PDO::PARAM_INT);
                if($stmt->execute() && ($stmt->rowCount() === 1)) {
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                }
}

function deleteInstructorById($id) {
    global $conn;
            $queryDeleteUser = $conn->prepare("DELETE FROM instruktor WHERE id = $id");
            //$queryDeleteUser->bindParam(':ID', $Id, PDO::PARAM_INT);
            return $queryDeleteUser->execute();

}

function deleteUserById($id) {
    global $conn;
            $stmt = $conn->prepare("DELETE FROM brugere WHERE fk_profil = $id");
            $stmt->execute();
            $queryDeleteUser = $conn->prepare("DELETE FROM profil WHERE id = $id");
            //$queryDeleteUser->bindParam(':ID', $Id, PDO::PARAM_INT);
            return $queryDeleteUser->execute();

}
