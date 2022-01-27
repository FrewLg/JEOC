<?php

namespace App\Twig;

use App\Entity\CollegeCoordinator;
use App\Entity\DirectorateOfficeUser;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CheckerExtension extends AbstractExtension
{
    private $em;
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('isCollegeCoordinator', [$this, 'isCollegeCoordinator']),
            new TwigFunction('isDirectorate', [$this, 'isDirectorate']),
            new TwigFunction('hasRole', [$this, 'hasRole']),
            new TwigFunction('allowedToSubmitReport', [$this, 'allowedToSubmitReport']),
        ];
    }

    public function isCollegeCoordinator($user)
    {
        $collegeCoordinator=$this->em->getRepository(CollegeCoordinator::class)->findOneBy(["coordinator"=>$user]);
        if ($collegeCoordinator){
            return $collegeCoordinator;
        }
        return null;
   
    }
    public function isDirectorate($user)
    {
        $director=$this->em->getRepository(DirectorateOfficeUser::class)->findOneBy(["directorate"=>$user]);
        if ($director){
            return $director;
        }
        return null;
   
    }
    public function hasRole($user,$role)
    {
        if(in_array($role,$user->getRoles())){
            return true;
        }

        return false;
   
    }
    public function allowedToSubmitReport($setting,$research_reports)
    {
        $count=count($research_reports);
       
        if ((new \DateTime('now')) > $setting[$count]->getSubmissionDate()) {
            return $setting[$count]->getSubmissionDate();
        }
       

        return false;
   
    }
}
