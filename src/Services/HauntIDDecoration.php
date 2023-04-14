<?php

namespace HauntPet\Auth\Services;

class HauntIDDecoration
{
    /**
     * The primary color for HauntID.
     *
     * @var string
     */
    private string $color = '#226077';

    /**
     * Show a login button.
     *
     * @param  string  $text
     * @return string
     */
    public function loginButton(string $text = 'Continue with HauntID'): string
    {
        return '<div style="color: white; background-color: '.$this->color.'; display: flex; border: 1px solid '.$this->color.'; align-items:center; box-shadow: 0 1px 2px 0 rgba(0,0,0,.25);">
            <link rel="preconnect" href="https://fonts.bunny.net">
            <link href="https://fonts.bunny.net/css?family=roboto:500" rel="stylesheet" />
            <div style="background-color: white; padding: 8px;">
                '.$this->logo().'
            </div>
            <div style="padding:0 15px; font-family: Roboto;">
                '.$text.'
            </div>
        </div>';
    }

    /**
     * Fetch the HauntID logo.
     *
     * @return string
     */
    public function logo(): string
    {
        return '<img
            style="height:30px; width: 30px; display: inline-block; transform: scaleX(-1);"
            src="https://img.icons8.com/dotty/80/null/ghost.png"
        >';
    }
}
