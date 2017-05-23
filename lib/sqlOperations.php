<?php

/**
 * Oprettet en bruger i databasen
 *
 * @param string $sql
 * @param array $data
 * @return boolean
 */
function sqlQueryPrepared($sql, $data) {
    global $conn;
    $stmt = $conn->prepare($sql);
    //$stmt->bindParam($data);
    return $stmt->execute($data);
}