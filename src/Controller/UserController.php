<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\RegisterUserType;
use App\Form\Type\UserPasswordType;
use App\Form\Type\UserProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/register", name="register_user")
     */
    public function registerAction(Request $request): Response
    {
        $form = $this->createForm(RegisterUserType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            $user->addRole(User::ROLE_USER);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $token = new UsernamePasswordToken($user, $user->getPassword(), "main", $user->getRoles());
            $this->get("security.token_storage")->setToken($token);
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('pages/user/register.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/user/update", name="user_update")
     */
    public function updateProfileAction(Request $request): Response
    {
        $form = $this->createForm(UserProfileType::class, $this->getUser());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('fos_user.user_manager')->updateUser($form->getData());

            return $this->redirectToRoute('fos_user_profile_show');
        }

        return $this->render('pages/user/profile_update.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/user/update/password", name="user_update_password")
     */
    public function updatePasswordAction(Request $request): Response
    {
        $form = $this->createForm(UserPasswordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $user->setPlainPassword($form['plainPassword']->getData());

            $this->get('fos_user.user_manager')->updateUser($user);

            return $this->render('pages/user/password_update.html.twig');
        }

        return $this->render('pages/user/password_update.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param User $user
     *
     * @return Response
     *
     * @Route("/user/profile/show/{id}", name="fos_user_profile_show")
     */
    public function viewUserProfileAction(User $user): Response
    {
        return $this->render('@FOSUser/Profile/show_content.html.twig', ['user' => $user]);
    }

    /**
     * @return Response
     *
     * @Route("/user/home", name="user_homepage")
     */
    public function userHomepageAction(): Response
    {
        return $this->render('pages/user/homepage.html.twig');
    }
}
