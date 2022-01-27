<?php
// src/Security/LoginFormAuthenticator.php
namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator implements PasswordAuthenticatedInterface
{
  use TargetPathTrait;

  public const LOGIN_ROUTE = 'app_login';

  private $entityManager;
  private $urlGenerator;
  private $csrfTokenManager;
  private $passwordEncoder;
  private $userRepository;
  private $is_ldap_user;
  private $user;
  private $flashBag;
  public function __construct(EntityManagerInterface $entityManager, FlashBagInterface $flashBagInterface, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder,      UserRepository $userRepository)
  {
    $this->entityManager = $entityManager;
    $this->urlGenerator = $urlGenerator;
    $this->csrfTokenManager = $csrfTokenManager;
    $this->userRepository = $userRepository;
    $this->is_ldap_user = false;
    $this->user = null;
    $this->passwordEncoder = $passwordEncoder;
    $this->flashBag = $flashBagInterface;
  }

  public function supports(Request $request)
  {
    #        return self::LOGIN_ROUTE === $request->attributes->get('_route')
    //        die('Our authenticator is alive!'); 
    return $request->attributes->get('_route') === 'app_login'
      && $request->isMethod('POST');
  }

  public function getCredentials(Request $request)
  {


    $credentials = [
      'username' => $request->request->get('username'),
      'password' => $request->request->get('password'),
      'csrf_token' => $request->request->get('_csrf_token'),
    ];
    $request->getSession()->set(
      Security::LAST_USERNAME,
      $credentials['username']
    );
    #         dd($credentials);

    return $credentials;
  }

  public function getUser($credentials, UserProviderInterface $userProvider)
  {
    $token = new CsrfToken('authenticate', $credentials['csrf_token']);
    if (!$this->csrfTokenManager->isTokenValid($token)) {
      throw new InvalidCsrfTokenException();
    }
    // from local database or ldap
    // $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $credentials['username']]);

    $ldapuser = $userProvider->getUserEntityCheckedFromLdap($credentials['username'], $credentials['password']);

    //  dd($user);

    if ($ldapuser) {
      $this->is_ldap_user = true;
      return $ldapuser;
    }
    $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $credentials['username']]);

    $this->user = $user;
    // if (!$user) { 
    //     throw new CustomUserMessageAuthenticationException('Invalid Credentials.');
    //     // throw new CustomUserMessageAuthenticationException('Username could not be found.');
    // } else {

    //     $this->is_ldap_user = true;
    // }

    return $user;
  }

  public function checkCredentials($credentials, UserInterface $user)
  {
    return true;
    if ($this->is_ldap_user) {
    }

    return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
  }

  /**
   * Used to upgrade (rehash) the user's password automatically over time.
   */
  public function getPassword($credentials): ?string
  {
    return $credentials['password'];
  }

  public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
  {



    $user = $token->getUser();
    // dd($user);


    /**
     * update last login 
     */
    $user->setLastLogin(new \DateTime('now'));
    $this->entityManager->flush();



    $permissions = [];
    foreach ($user->getRoles() as $role) {
      $permissions[] = $role;
    }

    $groups = $user->getUserGroup();
    foreach ($groups as $key => $value) {

      $permission = $value->getPermission();
      foreach ($permission as $key => $value1) {
        $permissions[] = $value1->getCode();
      }
    }
    $request->getSession()->set(
      "PERMISSIONS",
      $permissions
    );


    // if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
    //     return new RedirectResponse($targetPath);
    // }




    $roles = $token->getUser()->getRoles();
    if ($user->getIsSuperAdmin() || in_array("ROLE_ADMIN", $roles)) {



      return new RedirectResponse($this->urlGenerator->generate('submission_index'));
    }


    if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
      return new RedirectResponse($targetPath);
    }


    if ($user->getUserInfo() && !$user->getUserInfo()->getHasCompleteProfile()) {


      $this->flashBag->add("warning", "Please Complete Your profile!!");

      return new RedirectResponse($this->urlGenerator->generate('myprofile'));
    }

    return new RedirectResponse($this->urlGenerator->generate('homepage'));
  }

  protected function getLoginUrl()
  {
    return $this->urlGenerator->generate(self::LOGIN_ROUTE);
  }
}

