<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class LogoDimensions implements Rule
{
    protected $width;
    protected $height;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function passes($attribute, $value)
    {
        list($width, $height) = getimagesize($value);

        return $width === $this->width && $height === $this->height;
    }

    public function message()
    {
        return "The image must be {$this->width}x{$this->height} pixels.";
    }
}