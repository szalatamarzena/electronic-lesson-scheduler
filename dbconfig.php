<?php

try
{
    $username = "root";
    $password = "";

    $pdo = new PDO('mysql:host=localhost;dbname=dziennik;charset=utf8', $username, $password);
}
catch (PDOException $e)
{
    print "Błąd podczas połączena z bazą danych: " . $e->getMessage() . "</br>";
    die();
}