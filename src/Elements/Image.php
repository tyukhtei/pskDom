<?php
namespace App\Elements;

class Image extends Element
{
    public function render(): string
    {
        return "<img src='{$this->payload['image']['url']}' alt='Image'>";
    }
}