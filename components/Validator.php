<?php

class Validator
{
    public static function validateForm ($data) {
        $formValid = [];
        $formValid['valid'] = true;
        $formValid['validFields'] = [];
        $formValid['notValidFields'] = [];

        foreach ($data as $key => $value) {

            if ($key == 'insert') continue;

            if (isset($value) && (!empty($value) || $value === '0')) {

                $dataValid = trim($value);
                $dataValid = stripslashes($value);
                $dataValid = htmlspecialchars($value);

                $formValid['validFields'][$key] = $dataValid;
            } else {

                $formValid['valid'] = false;
                $formValid['notValidFields'][] = $key;
            }
        }

        return $formValid;
    }
}