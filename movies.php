<?php
require_once "includes/db.php";

function get_movie($db, $title) {
    $stmt = $db->prepare(
        "SELECT title, genre, duration, poster, times, price FROM movies WHERE title = ?"
    );
    $stmt->bind_param("s", $title);
    $stmt->execute();
    $movie = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($movie) {
        $movie["times"] = explode(",", $movie["times"]);   
    }
    return $movie;
}

function total_price($db, $title, $tickets) {
    $movie = get_movie($db, $title);
    return $movie ? $movie["price"] * $tickets : 0;
}