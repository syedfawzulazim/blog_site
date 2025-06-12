<?php
declare(strict_types=1);

function show($name, $stuff): void
{
    echo "<pre>";
    echo $name ." : ";
    print_r($stuff);
    echo "<pre>";
}

function redirect($url) : void
{
    header("Location: $url");
    exit;
}