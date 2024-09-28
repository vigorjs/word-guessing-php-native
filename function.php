<?php

function getRandomNumber($mysqli) {
    $sql = "SELECT COUNT(*) as total FROM master_kata";
    $result = $mysqli->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $totalRows = $row['total'];

        if ($totalRows > 0) {
            return rand(1, $totalRows);
        } else {
            return false;
        }
    } else {
        echo "Error executing query: " . $mysqli->error;
        return false;
    }
}

function getRandomKata($mysqli, $idKata){
    $sql = "SELECT * FROM master_kata WHERE id = ?";

    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $idKata);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return "No record found for ID: $idKata";
        }
    } else {
        return "Error preparing query: " . $mysqli->error;
    }
}