<?php
require_once 'vendor/autoload.php';
use App\Converters\JsonToHtmlConverter;

$jsonFilePath = 'source/data.json';
$json = file_get_contents($jsonFilePath);
if ($json === false)
{
    throw new Exception("Не удалось прочитать JSON файл: $jsonFilePath");
}

echo JsonToHtmlConverter::convert($json);

?>