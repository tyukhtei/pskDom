<?php
namespace App\Elements;

class ElementCreators
{
    public static function create(array $data): object
    {
        if (!isset($data['type']))
        {
            throw new Exception("Отсутствует тип элемента.");
        }

        switch ($data['type'])
        {
            case 'container':
                return new Container($data['payload'], $data['parameters'], self::createChildren($data['children']));
            case 'block':
                return new Block($data['payload'], $data['parameters'], self::createChildren($data['children']));
            case 'text':
                return new Text($data['payload'], $data['parameters'], []);
            case 'image':
                return new Image($data['payload'], [], []);
            case 'button':
                return new Button($data['payload'], $data['parameters'], []);
            default:
                throw new Exception("Неизвестный тип: {$data['type']}");
        }
    }

    private static function createChildren(array $childrenData): array
    {
        $children = [];
        foreach ($childrenData as $childData)
        {
            $children[] = self::create($childData);
        }
        return $children;
    }
}