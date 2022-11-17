<?php

class GenerateMask
{
    public static function generate($mask)
    {
        $regularMatch = '';

        for ($i = 0; $i < count($mask); $i++) {

            if ($i == 0) {

                $regularMatch = '/(^';

                switch ($mask[$i]) {
                    case 'N':
                        $regularMatch .= '[0-9].{0,0})';
                        break;
                    case 'A':
                        $regularMatch .= '[A-Z].{0,0})';
                        break;
                    case 'a':
                        $regularMatch .= '[a-z.{0,0}])';
                        break;
                    case 'X':
                        $regularMatch .= '[A-Z-z0-9].{0,0})';
                        break;
                    case 'Z':
                        $regularMatch .= '[-_@.{0,0}])';
                        break;
                    default:
                        $regularMatch .= ')';
                        break;
                }
            } else {

                switch ($mask[$i]) {
                    case 'N':
                        $regularMatch .= '+([0-9].{0,0})';
                        break;
                    case 'A':
                        $regularMatch .= '+([A-Z].{0,0})';
                        break;
                    case 'a':
                        $regularMatch .= '+([a-z.{0,0}])';
                        break;
                    case 'X':
                        $regularMatch .= '+([A-Z-z0-9].{0,0})';
                        break;
                    case 'Z':
                        $regularMatch .= '+([-_@.{0,0}])';
                        break;
                }
            }
        }

        $regularMatch .= '$/';

        return $regularMatch;
    }
}
