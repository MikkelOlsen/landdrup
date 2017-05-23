<?php



function userGet() {
    global $conn;
     $stmt = $conn->prepare("SELECT brugere.email, profil.fornavn, profil.efternavn, profil.fodselsdato, profil.adresse, profil.postnr, profil.tlf, profil.city 
                             FROM brugere 
                             INNER JOIN profil 
                             ON brugere.fk_profil = profil.id
                             WHERE brugere.id = :id");
                $stmt->bindParam(':id', $_SESSION['userid'], PDO::PARAM_INT);
                if($stmt->execute() && ($stmt->rowCount() === 1)) {
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                }
}