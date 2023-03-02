<?php

namespace App\Helpers;

class JsonHelper
{
    public static function convertJsonToHtmlList($jsonObject, $nested = false): string
    {
        // Decode JSON
        $data = json_decode($jsonObject, true);

        // Create an HTML list
        $html = '<ul' . ($nested ? ' style="display: none;"' : '') . '>';

        foreach ($data as $key => $value) {
            // If the value of $value is an array, then recursively call the function.
            if (is_array($value)) {
                $html .= '<li><button class="toggle-button">+</button>' . $key . ': ' . self::convertJsonToHtmlList(json_encode($value), true) . '</li>';
            } else {
                $html .= '<li>' . $key . ': ' . $value . '</li>';
            }
        }

        //Close an HTML list
        $html .= '</ul>';

        return $html;
    }

}
