<?php

namespace App\Converters;
use App\Elements\ElementCreators;

class JsonToHtmlConverter
{
    public static function convert(string $json): string
    {
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE)
        {
            throw new Exception("Недопустимый JSON файл: " . json_last_error_msg());
        }

        $element = ElementCreators::create($data);
        return $element->render();
    }
}