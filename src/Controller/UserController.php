<?php

namespace App\Controller; 
use App\Entity\CollegeCoordinator;
use App\Entity\Department;
use App\Entity\DirectorateOfficeUser;
use App\Entity\PublishedResearch;
use App\Entity\User;
use App\Entity\UserInfo;
use App\Entity\Submission;
use App\Entity\Subscription;
use App\Form\ChangePasswordFormType;
use App\Form\CollegeCoordinatorType;
use App\Form\DirecotorateOfficeUserType;
use App\Form\PublishedResearchType;
use App\Form\UserProfilePictureType;
use App\Form\UserProfileType;
use App\Form\UserType;
use App\Message\SendEmail;
use App\Message\SendEmailMessage;
use App\Repository\UserRepository;
use App\Repository\SubmissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\AnnouncementRepository;
use App\Repository\DepartmentRepository;
use App\Repository\PublishedResearchRepository;
use App\Utils\Constants;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\JsonResponse;


use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/appinfo", name="app_index", methods={"GET"})
     */
    public function appindex(UserRepository $userRepository,Request $request): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");
        
      
        return $this->render('appinfo.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
    /**
     * @Route("/finduser", name="user_ajax", methods={"GET","POST"})
     */
    public function findUser(UserRepository $userRepository,Request $request): Response
    {
        $users=$userRepository->search($request->request->get('q'));
        $data=[];
        $data["items"]=$users;
        $data["total_count"]=10;
        return new JsonResponse($data);
    }

    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $this->denyAccessUnlessGranted("ROLE_USER"); 
        $queryBuilder = $userRepository->getData(['name' => $request->query->get('search')]);
          $data = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),

            $request->query->getInt('limit', 10)
        );

        $isFiltered = false;
        return $this->render('user/index2.html.twig', [
            'users' => $data,
            "isFiltered" => $isFiltered,
        ]);
    }



    /**
     * @Route("/{id}/show", name="user_show", methods={"GET","POST"})
     */
    public function show(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER"); 
        $em = $this->getDoctrine()->getManager(); 
        if ($request->request->get('toggle_status')) { 
            $this->denyAccessUnlessGranted('usr_tgl_sts'); 
            if (!$this->getUser()->getIsSuperAdmin()) {
                // do not reset super admin
                if ($user->getIsSuperAdmin()) {
                    $this->addFlash("warning", "You Are not allowed to access this account!! ");
                    return $this->redirectToRoute('user_show', ["id" => $user->getId()]);
                }
            } 
            $user->setIsActive(!$user->getIsActive()); 
            $em->flush(); 
            $this->addFlash("success", "Status Changed!!");
            return $this->redirectToRoute('user_show', ["id" => $user->getId()]);
        }

        /**
         * set college co ordinator
         */
        $collegeCordinator = new CollegeCoordinator();
        $collegeCordinator->setCoordinator($user);
        $college_coordinator_form = $this->createForm(CollegeCoordinatorType::class, $collegeCordinator);
        $college_coordinator_form->handleRequest($request);

        if ($college_coordinator_form->isSubmitted() && $college_coordinator_form->isValid()) {

            $this->denyAccessUnlessGranted("assn_clg_cntr");

            if (in_array(Constants::ROLE_COLLEGECOORDINATOR, $user->getRoles())) {

                $collegeCordinator->setAssignedBy($this->getUser());
                $em->persist($collegeCordinator);
                $em->flush();

                /**
                 * send  email
                 */

                $content=[
                    "name" => $user->getUserInfo()->getSuffix().", ",$user->getUserInfo()->getFirstName(),
                    "firstName" => $user,
                    "Authoremail" => $user->getEmail(),
                    "submission_url" => "#",
                    "app_url" => "#",
   
                ];


                $sendEmail = new SendEmailMessage($user->getEmail(), Constants::EMAIL_KEY_SUBMISSION_ACKNOWLEDGEMENT, "emails/application_ack.html.twig", [
                                  ]);
                $this->dispatchMessage($sendEmail);



                $this->addFlash("success", sprintf("%s is Assigned as College Coordinator to %s college", $user, $collegeCordinator->getCollege()));
                return $this->redirectToRoute('user_show', ["id" => $user->getId()]);
            } else {
                $this->addFlash("warning", sprintf("%s has not College Coordinator Role. please assign before continue", $user));
            }
        }


        /**
         * set directorate
         */

        $directorateOfficeUser = new DirectorateOfficeUser();
        $directorateOfficeUser->setDirectorate($user);
        $directorateOfficeUser_form = $this->createForm(DirecotorateOfficeUserType::class, $directorateOfficeUser);
        $directorateOfficeUser_form->handleRequest($request);


        if ($directorateOfficeUser_form->isSubmitted() && $directorateOfficeUser_form->isValid()) {

            $this->denyAccessUnlessGranted("assn_drctr");

            if (in_array(Constants::ROLE_DIRECTORATE, $user->getRoles())) {

                $directorateOfficeUser->setAssignedAt(new \DateTime());
                $directorateOfficeUser->setStatus(1);
                $em->persist($directorateOfficeUser);
                $em->flush();

                /**
                 * send  email
                 */
                $content=[
                    "name" => $user->getUserInfo()->getSuffix().", ",$user->getUserInfo()->getFirstName(),
                    "firstName" => $user,
                    "Authoremail" => $user->getEmail(),
                    "submission_url" => "#",
                    "app_url" => "#",
   
                ];


                $sendEmail = new SendEmailMessage($user->getEmail(), Constants::EMAIL_KEY_SUBMISSION_ACKNOWLEDGEMENT, "emails/application_ack.html.twig", [
                                  ]);
                $this->dispatchMessage($sendEmail);


                $this->addFlash("success", sprintf("%s is Assigned as Directorate to %s office", $user->getFullName(), $directorateOfficeUser->getDirectorateOffice()));
                return $this->redirectToRoute('user_show', ["id" => $user->getId()]);
            } else {
                $this->addFlash("warning", sprintf("%s has not Directorate Role. please assign before continue", $user->getFullName()));
            }
        }


        return $this->render('user/show.html.twig', [
            'user' => $user,
            'college_coordinator_form' => $college_coordinator_form->createView(),
            'directorateOfficeUser_form' => $directorateOfficeUser_form->createView(),

        ]);
    }
    /**
     * @Route("/{id}/reset", name="reset_password", methods={"GET","POST"})
     */
    public function reset(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");


        return $this->render('user/show.html.twig', [
            'user' => $user,

        ]);
    }
    /**
     * @Route("/{id}/detail", name="user_details", methods={"GET","POST"})
     */
    public function details(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");


        return $this->render('user/detail.html.twig', [
            'user' => $user,

        ]);
    }


    /**
     * @Route("/{id}/researcher", name="researcher", methods={"GET","POST"})
     */
    public function researcher(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");  
        return $this->render('user/resercher.html.twig', [
            'user' => $user, 
        ]);
    }

    /**
     * @Route("/{id}/roles", name="roles", methods={"GET","POST"})
     */
    public function editrolesnew(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $form = $this->createFormBuilder($user)
            ->add('groups', EntityType::class, array(
                'class' => 'App\Entity\Group',
                'attr' => array('class' => 'chosen-select form-control col-xs-5 row-xs-5', 'style' => 'height: 200px'),
                'multiple' => true,
                'required' => false
            ))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/roles.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="tuser_new", methods={"GET","POST"})
     */
    public function rnew(Request $request): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/newe", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");
        $user = new User();
        $form = $this->createFormBuilder($user)
            ->add('image', FileType::class, array(
                'label' => 'Upload document',
                'required' => false
            ))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file3 = $user->getImage();
            if ($file3 == NULL) {
                
                $this->addFlash("warning", "Sorry you have to upload your original or temporary document !");
            }
            if ($file3) {
                $fundeddocDocsfileName3 = md5(uniqid()) . '.' . $file3;
                $file3->move($this->getParameter('letters_directory'), $fundeddocDocsfileName3);
                $user->setImage($fundeddocDocsfileName3);
            }

            return $this->redirectToRoute('user_new');
        }
        return $this->render('user/new2.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/manage-roles", name="user_roles_edit", methods={"GET","POST"})
     */
    public function manageroles(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted("usr_edt");

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('user_index');
        }
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/resercher", name="resercher_detail", methods={"GET","POST"})
     */
    public function resercher(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $em = $this->getDoctrine()->getManager();
	$qb = $em->createQueryBuilder();
	$totalSubmissions = $qb
	->select( 'COUNT(e.id) as Proposals , e.submission_type as Subbmission_type' )
	->from( 'App\Entity\Submission' , 'e'   )
	->andWhere(  'e.author = :publisher' ) 
	->setParameter( 'publisher', $user ) 
	->groupBy('e.submission_type')
	->getQuery()->getResult();
	; 
	
		$qb2 = $em->createQueryBuilder();
	$usersubmission = $qb2
	->select( 'COUNT(s.id) as Submissions , s.submission_type as research' )
	->from( 'App\Entity\Submission' , 's'   )
	 //->andWhere(  's.complete = :status' ) 
	->andWhere(  's.author = :author' ) 
	//->setParameter( 'status', 'complete' ) 
	->setParameter( 'author', $user ) 
	->groupBy('s.submission_type')
	->getQuery()->getResult();
	;
	
	$repoArticles = $em->getRepository('App:Submission'::class);
	$totalSubmissions = $repoArticles->createQueryBuilder('sc')
             ->select('count(sc.id) as ds')
             ->andWhere(  'sc.author = :author' ) 
             ->setParameter( 'author', $user ) 
            ->getQuery()
            ->getSingleScalarResult(); 
           $me = $this->getUser(); 
            	$subscriptions=$em->getRepository(Subscription::class)->findBy(['user'=>$me]);
        return $this->render('user/resercher.html.twig', [
            'user' => $user,
              'userpublication' => $totalSubmissions,
 'totalSubmissions' => $totalSubmissions,
 'subscriptions'=>$subscriptions,
 'usersubmissions'=>$usersubmission,

        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        // $this->denyAccessUnlessGranted("usr_edt");

        $form = $this->createForm(UserType::class, $user->getUserInfo());
        $form->get('roles')->setData($user->getRoles());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->get('user');

            $user->setRoles($data['roles']);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "Updated Successfully");
            return $this->redirectToRoute('user_show', ["id" => $user->getId()]);
        }
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    


    /**
     * @Route("/profile", name="myprofile", methods={"GET","POST"})
     */

    public function profile(Request $request, UserRepository $UserRepository, SubmissionRepository $submissionRepository)
    {
        
    return $this->redirectToRoute('researchworks' );
        
    }
    
 /**
     * @Route("/department_fetch", name="department_fetch")
     */
    public function departmentFetch(Request $request, DepartmentRepository $departmentRepository)
    {
        
        $em = $this->getDoctrine()->getManager();
        $college = $request->request->get("college");
        //  dd($principal);
        $departments = $departmentRepository->filterDepartments($college);
        // dd($principals);

        return new JsonResponse($departments);
    }
    #[Route('/update-profile', name: 'researchworks', methods: ['GET','POST'])]
    public function researchworks(Request $request): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");
 
        $em = $this->getDoctrine()->getManager();
        $entityManager = $this->getDoctrine()->getManager(); 

        $user = $this->getUser();
        if($user->getUserInfo()==''){
            $user_info=new UserInfo();
            $user_info->setUser($user);
            $em->persist($user_info);
            $em->flush();
        }
         $publishedResearch = $user->getUserInfo();
        $user_info = $user->getUserInfo(); 
        $form = $this->createForm(UserProfileType::class, $publishedResearch); 
         $form->handleRequest($request);
        $userInfo = $user->getUserInfo();

        $image = $user->getUserInfo();
        
        $profilepictureform = $this->createForm(UserProfilePictureType::class, $image); 
        $profilepictureform->handleRequest($request);
        if ($profilepictureform->isSubmitted() && $profilepictureform->isValid()) {
            $prifilepicture = $profilepictureform->get('image')->getData();
 
            if ($prifilepicture == NULL) {
                echo 'Image not uploaded';
                 $prifilepicture = '';
            } else {
                 $fileName3 =  md5(uniqid()) . '.' . $prifilepicture->guessExtension();
                $prifilepicture->move($this->getParameter('profile_pictures'), $fileName3);
                $userInfo->setImage($fileName3);
                $entityManager->persist($image);
                $entityManager->flush();
            $this->addFlash('success', "Profile picture  has been changed successfully!   ");
 
            } 
        }

        if ($form->isSubmitted() && $form->isValid()) {
 
        $dep=$request->request->get("department");
$udep = $entityManager->getRepository(Department::class)->findOneBy(array('name'=>$dep));
            // dd($udep);
        $userInfo->setDepartment($udep);
          

             $userInfo->setHasCompleteProfile(true);
            
            $entityManager->persist($publishedResearch);
            $entityManager->flush();
            
            $this->addFlash('success', "Your Profile  has been updated  successfully! <a href='/' class='text-info'> Go to homepage</a>   ");

            // return $this->redirectToRoute('call_for_proposal_all' );
        }
 
        $earlierprojects = $entityManager->getRepository(PublishedResearch::class)->find($this->getUser());
          
        return $this->render('user/profile2.html.twig', [
            'published_research' => $publishedResearch,
            'user' => $user,
            'alltitles'=>$earlierprojects,
            'submissionform' => $form->createView(), 
            'profilepicture' => $profilepictureform->createView(),
        ]);
    }


      /**
     * @Route("/checkuser", name="checkuser", methods={"GET","POST"})
     */
    public function checkuser() {

        $userdetails = $this->getUser()->getUserInfo();
        if($userdetails==''){
       // dd();
            $userInfo=new UserInfo(); 
            $userInfo->setUser($this->getUser()); 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userInfo);
            $entityManager->flush();
            return $this->redirectToRoute('researchworks');
       
        } 
        return $this->redirectToRoute('researchworks');

     }


      /**
     * @Route("/chaxnge-password", name="update_password", methods={"GET","POST"})
     */
    public function updatepassword( MailerInterface $email,    EntityManagerInterface $entityManager,
    UserPasswordEncoderInterface $passwordEncoder, Request $request): Response
    {

        $this->denyAccessUnlessGranted("ROLE_USER");

        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        
        $form = $this->createForm(ChangePasswordFormType::class, $user) ; 
 
        $form->handleRequest($request);  
        // dd($form);
       
        if ($form->isSubmitted()  ) {
             
            // $old=  $passwordEncoder->encodePassword($user,  $form->get('password')->getData()  );
            // $oldfromform= $passwordEncoder->encodePassword($user, $user->getPassword());
            
            // if($oldfromform!=$old){
            // $this->addFlash('danger', "Old password do not match!");
            // return $this->redirectToRoute('change_pasxsword');              }

            $user->setPassword(
                $passwordEncoder->encodePassword( $user, $form->get('plainPassword')->getData()
                )
            ); 
 
            $entityManager->flush();  
            $this->addFlash('success', "Password has been changed successfully!   ");
            return $this->redirectToRoute('homepage');
       
        } 
        return $this->render('user/change-password.html.twig', [
             'user' => $user, 
            'form' => $form->createView(),
        ]);
     }



    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted("rmv_usr");
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
