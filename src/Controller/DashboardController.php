<?php

namespace App\Controller;

use App\Entity\College;

use App\Entity\TrainingParticipant;
use App\Filter\Type\FilterFunctions;
use App\Utils\Constants;
use Composer\Console\HtmlOutputFormatter;
use Doctrine\ORM\Query\Expr;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard")
 */

class DashboardController extends AbstractController
{


  /**
   * @Route("/all/", name="aadashboard", methods={"GET","POST"})
   */
  public function dashboard(): Response
  {
    // $this->denyAccessUnlessGranted('assn_clg_cntr');

    $entityManager = $this->getDoctrine()->getManager();
             
  

    return $this->render('dashboard/index.html.twig', []);
  }


 
}
