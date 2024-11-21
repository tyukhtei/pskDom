<?php
namespace App\Elements;

class Text extends Element
{
    public function render(): string
    {
        $style = $this->getStyle();
        return "<p style='$style'>{$this->payload['text']}</p>";
    }
}