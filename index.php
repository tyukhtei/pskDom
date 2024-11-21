<?php
abstract class Element
{
    protected $payload;
    protected $parameters;
    protected $children;

    public function __construct($payload, $parameters, $children = []) {
        $this->payload = $payload;
        $this->parameters = $parameters;
        $this->children = $children;
    }

    abstract public function render();


    protected function getStyle() {
        $style = "";
        foreach ( $this->parameters as $parameter => $value ) {
            $result = preg_replace_callback('/([A-Z])/', function($matches) {
                return '-' . strtolower($matches[1]);
            }, $parameter);
            $style .= "$result: $value; ";
        }
        return $style;
    }
}

class Container extends Element
{
    public function render() {
        $style = $this->getStyle();
        $html = "<div style='$style'>";
        foreach ($this->children as $child) {
            $html .= $child->render();
        }
        $html .= "</div>";
        return $html;
    }

}

class Block extends Element
{
    public function render() {
        $style = $this->getStyle();
        $html = "<div style='$style'>";
        foreach ($this->children as $child) {
            $html .= $child->render();
        }
        $html .= "</div>";
        return $html;
    }
}

class Text extends Element {
    public function render() {
        $style = $this->getStyle();
        return "<p style='$style'>{$this->payload['text']}</p>";
    }
}

class Image extends Element {
    public function render() {
        return "<img src='{$this->payload['image']['url']}' alt='Image'>";
    }
}

class Button extends Element {
    public function render() {
        $style = $this->getStyle();
        return "<a href='{$this->payload['link']['payload']}' class='button' style='$style'>{$this->payload['text']}</a>";
    }
}

class ElementCreators
{
    public static function create($data) {
        if (!isset($data['type'])) {
            throw new Exception("Отсутствует тип элемента.");
        }

        switch ($data['type']) {
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

    private static function createChildren($childrenData) {
        $children = [];
        foreach ($childrenData as $childData) {
            $children[] = self::create($childData);
        }
        return $children;
    }
}

class JsonToHtmlConverter {
    public static function convert($json) {
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Недопустимый JSON файл: " . json_last_error_msg());
        }

        $element = ElementCreators::create($data);
        return $element->render();
    }
}

$jsonFilePath = 'source/data.json';
$json = file_get_contents($jsonFilePath);
if ($json === false) {
    throw new Exception("Не удалось прочитать JSON файл: $jsonFilePath");
}

echo JsonToHtmlConverter::convert($json);

?>