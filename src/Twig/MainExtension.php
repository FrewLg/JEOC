<?php

namespace App\Twig;

use App\Helper\MainHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MainExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'timeAgo']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('timeAgo', [$this, 'timeAgo']),
        ];
    }

    public function timeAgo($date1, $date2=null)
    {
        $date2??=new \DateTime('now');
       $days= MainHelper::getTimeElapsed($date1);
       return $days;
    }
   
}
