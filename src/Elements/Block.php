<?php
namespace App\Elements;

class Block extends Element
{
    public function render(): string
    {
        $style = $this->getStyle();
        $html = "<div style='$style'>";
        foreach ($this->children as $child)
        {
            $html .= $child->render();
        }
        $html .= "</div>";
        return $html;
    }
}