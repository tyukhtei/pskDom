<?php
namespace App\Elements;

class Button extends Element
{
    public function render(): string
    {
        $style = $this->getStyle();
        return "<a href='{$this->payload['link']['payload']}' class='button' style='$style'>{$this->payload['text']}</a>";
    }
}