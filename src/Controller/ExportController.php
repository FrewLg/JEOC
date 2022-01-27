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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/export")
 */

class    ExportController   extends AbstractController {
   
     
  
 
     /**
     * @Route("/participant", name="exportexcelparticipant", methods={"GET","POST"})
     */
    public function trainingparticipant(  )
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();
 
          $submissions = $em->getRepository(TrainingParticipant::class)->findAll();
         $spreadsheet = new Spreadsheet();
         /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No.');
        $sheet->setCellValue('B1', 'Full name');
         $sheet->setCellValue('C1', 'Participant\'s Institute');
        $sheet->setCellValue('D1', 'Participant\'s College');
        $sheet->setTitle("Participants");
 
        $counter = 2;
        foreach ($submissions as $phoneNumber) {
            $sheet->setCellValue('A' . $counter, $phoneNumber->getId()); 
            $sheet->setCellValue('B' . $counter, $phoneNumber->getParticipant()->getUserInfo());
            $sheet->setCellValue('C' . $counter, $phoneNumber->getParticipant()->getUserInfo()->getCollege());
            $sheet->setCellValue('D' . $counter, $phoneNumber->getParticipant()->getUserInfo()->getDepartment()); 
          $counter++;
        }
         $writer = new Xlsx($spreadsheet);
         $fileName = 'Traninig participant.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        
         $writer->save($temp_file);
        
         return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
         
    } 

      
    

     

}
