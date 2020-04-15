<?php
/* src/View/Helper/LinkHelper.php (using other helpers) */

namespace App\View\Helper;

use Cake\View\Helper;

class FormatHelper extends Helper
{
    public $helpers = ['Html'];

    public function plus($number)
    {
        if($number < 0) {
            return "-" . abs($number);
        } else if($number > 0) {
            return "+" . abs($number);
        } else {
            return $number;
        }
    }

    public function increase($number)
    {
        if($number < 0) {
            $out = "-" . number_format(abs($number),0,',',' ');
            $color="green";
        } else if($number > 0) {
            $out = "+" . number_format(abs($number),0,',',' ');
            $color="red";
        } else {
            $out = number_format($number,0,',',' ');
            //$out="";
            $color="black";
        }

        return '<span class="span-'.$color.'">(' . $out . ')</span>';
    }
}