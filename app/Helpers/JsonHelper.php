<?php

namespace App\Helpers;

class JsonHelper
{
    public static function convertJsonToHtmlList($jsonObject, $level = 0): string
    {
        //Decode JSON
        $data = json_decode($jsonObject, true);

        //Create an HTML list
        $html = '<ul>';

        foreach ($data as $key => $value) {
            //If the value of $value is an array, then recursively call the function.
            if (is_array($value)) {
                $html .= '<li>';
                $html .= '<button class="json-expand" onclick="toggleJson(this)">+</button>';
                $html .= '<span class="json-key">' . $key . '</span>';
                $html .= '<div class="json-value json-collapsed">';
                $html .= self::convertJsonToHtmlList(json_encode($value), $level + 1);
                $html .= '</div></li>';
            } else {
                $html .= '<li>' . '<span class="json-key">' . $key . '</span>: ' . '<span class="json-value">' . $value . '</span>' . '</li>';
            }
        }

        //Close an HTML list
        $html .= '</ul>';

        return $html;
    }

}
