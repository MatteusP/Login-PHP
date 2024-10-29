<?php
// includes/functions.php

function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

function verifyPassword($password, $hash)
{
    return password_verify($password, $hash);
}

function fetchTitleFromAPI()
{
    $response = file_get_contents('https://jsonplaceholder.typicode.com/posts/1');
    $data = json_decode($response, true);
    return $data['title'] ?? '';
}
