<?php
namespace App\Elements;

abstract class Element
{
    protected $payload;
    protected $parameters;
    protected $children;

    public function __construct($payload, $parameters, $children = [])
    {
        $this->payload = $payload;
        $this->parameters = $parameters;
        $this->children = $children;
    }

    abstract public function render();


    protected function getStyle()
    {
        $style = "";
        foreach ( $this->parameters as $parameter => $value )
        {
            $result = preg_replace_callback('/([A-Z])/', function($matches)
            {
                return '-' . strtolower($matches[1]);
            }, $parameter);
            $style .= "$result: $value; ";
        }
        return $style;
    }
}