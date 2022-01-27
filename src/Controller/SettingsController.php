<?php

namespace App\Controller;

use App\Entity\User; 
use App\Entity\SiteSetting; 
use App\Entity\BackupHistory;
use App\Entity\BackupSetting;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Parser;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Form\Extension\Core\Type\FileType; 
/**
 * @Route("/website")
 */
 
class SettingsController extends AbstractController
{
    

    /**
     * @Route("/settings", name="app_setting" , methods={"GET","POST"})
     */
    public function settings(Request $request  ): Response
    {   	
	//var_dump(yaml_emit($invoice));
	// $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN'); 
     $em= $this->getDoctrine()->getManager();   
$siteSetting=$em->getRepository('App:SiteSetting'::class)->findOneBy(array('id'=>1));
	$form = $this->createFormBuilder($siteSetting)   
 

         ->add('name' , TextType::class, [
            'attr' => [
                'placeholder' => 'Name',
                'class'=>'form-control   ',
                'required' => false,
            ]])
             ->add('site_logo', FileType::class, [
                'label' => 'Upload your site logo', 
                'mapped' => false, 
                'required' => false, 
                  'attr' => [
                  'class'=>'form-control   ',
                'required' => false,
            ] 
            ])  
             ->add('motto' , TextType::class, [
            'attr' => [
                'placeholder' => 'Motto',
                 'class'=>'form-control   ',
                'required' => false,
            ]]) 
            
              ->add('app_url' , TextType::class, [
            'attr' => [
                'placeholder' => 'App URL',
                 'class'=>'form-control   ',
                'required' => false,
            ]]) 
           ->add('corporate_color' , TextType::class, [
            'attr' => [
                'placeholder' => 'Corporate color',
                'required' => false,
                'class'=>'form-control my-colorpicker1 colorpicker-element  ',
                'data-colorpicker-id'=>'1',
                'id'=>'form_corporate_co',
                'data-original-title'=>"",
            ]])
            
       ->add('navbar_background',  ChoiceType::class, [
       'placeholder' => '-- Select background color for nav bar --',
      'choices' => [  
            'Dark' => 'dark',
            'Light' => 'light',
            'White' => 'white',
            'Grey' => 'grey',
            'Success' => 'success',
            'Teal' => 'teal',
            'Light blue' => 'lightblue',
            'Secondary' => 'secondary',
            'Indigo' => 'indigo',
    ],
     'attr' => [
                'class' => 'form-control',
                'required' => true,
            ] ,            
])     
  
             ->add('app_description' ,  CKEditorType::class,[
    'attr'=>['placeholder'=>'Describe your reason why',
    'class' => 'form-control',
                 'required' => false,
            
	],])   
	
	->add('contact_address'  ,  CKEditorType::class,[
    'attr'=>['placeholder'=>'Describe your reason why',
    'class' => 'form-control',
    'required' => false,
            
	],])     
    ->add('about'  ,  CKEditorType::class,[
    'attr'=>['placeholder'=>'Describe your reason why',
    'class' => 'form-control',
    'required' => false,
            
	],])     
             ->add('privacy_statement' ,  CKEditorType::class,[
    'attr'=>['placeholder'=>'Describe your reason why',
    'class' => 'form-control',
                 'required' => false,
            
	],])                
	     ->add('copy_right' ,  CKEditorType::class,[
    'attr'=>['placeholder'=>'Copy rigght notice',
    'class' => 'form-control',
                 'required' => false,
            
	],])  
	 ->getForm(); 
        $form->handleRequest($request); 
        
        if ($form->isSubmitted() && $form->isValid()) {
            $file3 = $form->get('site_logo')->getData();  
            $siteSettinglogo = $form->get('site_logo')->getData();  
	// $siteSettinglogo = $siteSetting->getSiteLogo();   
            if ($file3==NULL){ 
             $ddd=$siteSetting->setSiteLogo($siteSettinglogo); 
            $fileName3=$ddd->getSiteLogo();
  	 echo 'File not uploaded';
	}   else{
	 $file3 = $form->get('site_logo')->getData();  
          $fileName3 =  md5(uniqid()).'.'.$file3->guessExtension();  
	  $file3->move($this->getParameter('site_setting'), $fileName3);  
        //    $siteSetting->setSiteLogo($fileName3); 
         }  
         
           $this->getDoctrine()->getManager()->flush();
///////////////////////

   $settings = array (
   "twig"=>array(
   "globals"=>array(
    // "prefix"=> $siteSetting->getPrefix(),
    "app_name"=> $siteSetting->getName(),
     "app_description"=> $siteSetting->getAppDescription(),
     "organization"=> $siteSetting->getOrganization(),
     "app_url"=> $siteSetting->getAppUrl(),
     "site_logo"=> $fileName3,
     "copyright"=>   $siteSetting->getCopyright(),
     'navbar_background' => $siteSetting->getNavbarBackground(),
     "acronym"=>  $siteSetting->getAppDescription(),
     "corporate_color"=> $siteSetting->getCorporateColor(),
     "motto"=> $siteSetting->getMotto(),
     "contact_us"=>  $siteSetting->getContactAddress(),
     "about"=> $siteSetting->getAbout(),
     "privacy_statement"=> $siteSetting->getPrivacyStatement(),
       
        
  )
  )
  );
  
          try {
    $yaml = Yaml::dump($settings);
            file_put_contents($this->getParameter('site_settingsfile'), $yaml);
	} catch (ParseException $exception) {
    printf('Unable to parse the YAML string: %s', $exception->getMessage());
	} 
	
	return $this->redirectToRoute('app_setting', array('id'=>$siteSetting->getId()));
        }
        
 
 
	$writtenvalue = Yaml::parseFile($this->getParameter('site_settingsfile'));
        return $this->render('site_setting/muke.html.twig', [
            'site_setting' => $siteSetting,
            'form' => $form->createView(),
 
        ]);
}

   /**
     * @Route("/backupsettings", name="app_backup_setting" , methods={"GET","POST"})
     */
    public function backupsettings(Request $request  ,  PaginatorInterface $paginator ): Response
    {   	
	//var_dump(yaml_emit($invoice));
	 
	/////////////////// BackupSetting /////////////
	$entityManager = $this->getDoctrine()->getManager();
   
    $backupSetting = $entityManager->getRepository(BackupSetting::class)->find(1);
    if($backupSetting){
        
    }else{
        // dd($backupSetting);
        $backup= new BackupSetting();
        $backup->setEmailfrom('1');
        $backup->setEmailTo('1');
        $backup->setEmailSubject('1');
        $backup->setDbUser('name');
        $backup->setDbPassword('name');
        $backup->setDestinationDir('name');
        $backup->setLogfileName('name');
        $backup->setMysqlHost('name');
        $backup->setRemoteMachineIp('name');
        $backup->setEmailtoCc('name');
        $backup->setEmailto('name');
        $backup->setRemoteAppDir('name');
        $backup->setRemoteDbDir('name');
        $backup->setSourceDir('name');
        $backup->setGmailPass('name'); 
        $this->getDoctrine()->getManager()->persist( $backup);
        $this->getDoctrine()->getManager()->flush();
    }

	$BackupForm = $this->createFormBuilder($backupSetting)   
         
            ->add('mysql_host', TextType::class, [
            'attr' => [
                'placeholder' => 'Host',
                'class'=>'form-control   ',
                'required' => false,
            ]] )
   ->add('db_user' , TextType::class, [
            'attr' => [
                'placeholder' => 'Database user',
                'class'=>'form-control   ',
                'required' => false,
            ]])
  ->add('db_password' , PasswordType::class, [
            'attr' => [
                'placeholder' => 'Database password',
                'class'=>'form-control   ',
                'required' => false,
            ]]) 
   ->add('source_dir' , TextType::class, [
            'attr' => [
                'placeholder' => 'Destination source dir',
                'class'=>'form-control   ',
                'required' => false,
            ]]) 
            
  ->add('destination_dir' , TextType::class, [
            'attr' => [
                'placeholder' => 'Name',
                'class'=>'form-control   ',
                'required' => false,
            ]])
   ->add('logfile_name' , TextType::class, [
            'attr' => [
                'placeholder' => 'Name',
                'class'=>'form-control   ',
                'required' => false,
            ]]) 

            ->add('remote_machine_ip', TextType::class, [
            'attr' => [
                'placeholder' => 'Remote machine IP ',
                'class'=>'form-control   ',
                'required' => false,
                'maxlength'=>'12',
            ]] ) 
   ->add('remote_app_dir' , TextType::class, [
            'attr' => [
                'placeholder' => 'Remote machine directory',
                'class'=>'form-control   ',
                'required' => false,
            ]]) ->add('remote_db_dir' , TextType::class, [
            'attr' => [
                'placeholder' => 'Remote machine database directory',
                'class'=>'form-control   ',
                'required' => false,
            ]]) 
   ->add('gmail_user' , TextType::class, [
            'attr' => [
                'placeholder' => 'Gmail user',
                'class'=>'form-control   ',
                'required' => false,
            ]]) 
   ->add('gmail_pass', PasswordType::class, [
            'attr' => [
                'placeholder' => 'Gmail password',
                'class'=>'form-control   ',
                'required' => false,
            ]] ) 
      ->add('backup_days' , TextType::class, [
            'attr' => [
                'placeholder' => 'BAckup days ',
                'class'=>'form-control   ',
                'required' => false,
            ]])  
 ->add('emailfrom' , TextType::class, [
            'attr' => [
                'placeholder' => 'Email from',
                'class'=>'form-control   ',
                'required' => false,
            ]])
            ->add('emailto' , TextType::class, [
            'attr' => [
                'placeholder' => 'Email recepient',
                'class'=>'form-control   ',
                'required' => false,
            ]])
            ->add('emailto_cc' , TextType::class, [
            'attr' => [
                'placeholder' => 'Email cc',
                'class'=>'form-control   ',
                'required' => false,
            ]])
            ->add('email_subject' , TextType::class, [
            'attr' => [
                'placeholder' => 'Email subject',
                'class'=>'form-control   ',
                'required' => false,
            ]])
             ->add('email_body' ,  CKEditorType::class,[
    'attr'=>['placeholder'=>'Email body',
    'class' => 'form-control',
                 'required' => false,
	],])  
	 ->add('signature' ,  CKEditorType::class,[
    'attr'=>['placeholder'=>'Signature',
    'class' => 'form-control',
                 'required' => false,
	],])  
	 ->getForm(); 
	 $BackupForm->handleRequest($request); 
            if ($BackupForm->isSubmitted() && $BackupForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
	$backupSetting->setSourceDir($this->getParameter('project_dir'));
	$SRCDIR=$this->getParameter('project_dir');
	//dd($SRCDIR);
	$emailto=$backupSetting->getEmailTo();
	$emailsubj=$backupSetting->getEmailSubject();
	/////////////////contents/////////// getDbUser
	$content1=PHP_EOL ."DESTIP='".$backupSetting->getRemoteMachineIp()."'\n"."BKP_USER='".$backupSetting->getDbUser()."'";
	$content2=PHP_EOL ."BKP_PASS='".$backupSetting->getDbPassword()."'\n";
	$content3=PHP_EOL ."SRCDIR='".$SRCDIR."'\n"."DESTDIR='".$backupSetting->getDestinationDir()."'"; 
	$content4=PHP_EOL ."logfile='".$backupSetting->getLogfileName()."'\n";	
	
	$content5=PHP_EOL ."BKP_DAYS='".$backupSetting->getBackupDays()."'\n"."MYSQL_HOST='".$backupSetting->getMysqlHost()."'";
 	
	$content7=PHP_EOL ."SUBJECT='".$emailsubj."'\n"."DESTREMOTEDBDIR='".$backupSetting->getRemoteDbDir()."'";
	$content8=PHP_EOL ."DESTREMOTEAPPDIR='".$backupSetting->getRemoteAppDir()."'\n"."SGINATURE='".$backupSetting->getSignature()."'";	

	$content9=PHP_EOL ."SIGNATURE='".$backupSetting->getEmailTo()."'\n"."EMAILFROM='".$backupSetting->getEmailFrom()."'";
	$content10=PHP_EOL ."EMAILRECIPIENT='".$backupSetting->getEmailTo()."'\n"."EMAILRECIPIENTTWO='".$emailto."'";	
	$content11=PHP_EOL ."EMAILBODY='".$backupSetting->getEmailBody()."'\n"."GEMAILUSER='".$backupSetting->getGmailUser()."'";
	$content12=PHP_EOL ."GMAILPASS='".$backupSetting->getGmailPass()."'\n"."EMAILRECIPIENTTWO='".$backupSetting->getEmailtoCc()."'";	
 

	///////////////contents//////////
	$thefile=$this->getParameter('site_backup_settings_file');
	$output = shell_exec('sh '.$thefile.'');
	file_put_contents($this->getParameter('site_backup_settings_file'),  			  	         $content1.$content2.$content3.$content4.$content5.$content7.$content8.$content9.$content10.$content11.$content12 );
	  $this->addFlash(
            'success',
            'Settings saved successfully!'
      ); 
	}
	$em=$this->getDoctrine()->getManager();
	$backuphistory=$em	->getRepository(BackupHistory::class)->findAll();
	   $Allbackups = $paginator->paginate(
            // Doctrine Query, not results
            $backuphistory,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );
        
       
      
        return $this->render('site_setting/backup-settings.html.twig', [
            'backup_setting' => $backupSetting,
            'backuphistories' => $Allbackups,
            'BackupForm'=>$BackupForm->createView(),
        ]);
}

 /**
     * @Route("/{id}/execbackup", name="execbackup" , methods={"GET","POST"})
     */
    public function execbackupsettings(Request $request , BackupSetting   $backupSetting     ): Response
    { 
	$site_backup_file=$this->getParameter('site_backup_file');
	$output = shell_exec($site_backup_file);
	$backupHistory = new BackupHistory();  
        $entityManager = $this->getDoctrine()->getManager();
            $backupHistory->setSuccessful(1);
            $backupHistory->setRemoteIp($this->getParameter('project_dir'));
            $backupHistory->setBackupDate(new \DateTime());
            $SRCDIR=$this->getParameter('project_dir');
            $backupHistory->setResPath($this->getParameter('project_dir'));
            $entityManager->persist($backupHistory);
            $entityManager->flush();
	$this->addFlash(
            'success',
            'Database and resource file backed up successfully!'
      ); 
         return $this->redirectToRoute('app_backup_setting', array('id' => $backupSetting->getId()));
           
    }


}

