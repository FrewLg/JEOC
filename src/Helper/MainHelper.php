<?php
namespace App\Helper;

use DateTimeInterface;

class MainHelper{

    public static function getTimeElapsed($datetime, $date2=null, $full = false)
    {
        
        $now=$date2?:new \DateTime;
        $ago =($datetime  instanceof DateTimeInterface)? $datetime:(new \DateTime($datetime));
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        if($now>$ago)
        return $string ? implode(', ', $string) . ' ago' : 'just now';
        return $string ? implode(', ', $string) . ' left' : 'just now';
    }
}