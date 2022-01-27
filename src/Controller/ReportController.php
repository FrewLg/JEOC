<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;  
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Entity\Review;
use Symfony\Component\Form\Extension\Core\Type\DateType; 
use App\Entity\CollaboratingInstitution;
use App\Form\CollaboratingInstitutionType;
use App\Repository\CollaboratingInstitutionRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\WorkUnit;
use App\Repository\WorkUnitRepository;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use App\Repository\InstitutionalReviewersBoardRepository;
use App\Entity\InstitutionalReviewersBoard;
use Lexik\Bundle\FormFilterBundle\Filter\Condition\ConditionBuilderInterface; 
use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Repository\ReviewRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType; 
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Filter\Type\FilterFunctions; 
use Doctrine\DBAL\Abstraction\Result;

/**
 * @Route("/report")
 */
class ReportController extends AbstractController
{
    
   
}
