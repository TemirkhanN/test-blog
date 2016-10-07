<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\User;
use BlogBundle\Form\LoginType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class UserController
 * @package BlogBundle\Controller
 */
class UserController extends Controller
{

    /**
     * Вход в систему
     *
     * TODO за "корректным" решением вернуться сюда http://symfony.com/doc/current/bundles/FOSUserBundle/index.html
     *
     * @param Request $request
     *
     * @return Response
     */
    public function loginAction(Request $request)
    {
        $session = new Session();
        //Если пользователь уже авторизован, перебрасываем его на главную страницу
        if ($session->get('user_info')) {
            return $this->redirect($this->generateUrl('blog_posts'));
        }

        $user = new User();

        $loginForm = $this->createForm(LoginType::class, $user);

        $loginForm->handleRequest($request);

        if ($loginForm->isSubmitted() && $loginForm->isValid()) {
            $dbUser = $this
                ->getDoctrine()
                ->getRepository('BlogBundle:User')
                ->findOneBy([
                    'login' => $user->getLogin(),
                ]);

            if ($dbUser && password_verify($user->getPassword(), $dbUser->getPassword())) {
                $dbUser->setLastSigned(new \DateTime());
                $this->getDoctrine()->getManager()->flush();

                $session->set('user_info', $dbUser);

                return $this->redirect($this->generateUrl('blog_posts'));
            }

            $session->getFlashBag()->add('error', 'Пользователя с такими данными не существует');
        }

        return $this->render('BlogBundle:user:login.html.twig', ['login_form' => $loginForm->createView()]);
    }

    /**
     * Выход из системы
     */
    public function logoutAction()
    {
        //Все проверки на уже авторизованного пользователя в контексте задачи не имеют смысла. Сносим данные и редиректим
        (new Session())->remove('user_info');

        return $this->redirect($this->generateUrl('blog_posts'));
    }

    /**
     * Просто для "быстрого" создания пользователя
     *
     * @Route("/create_user")
     */
    public function createUserAction()
    {
        $userLogin = 'James';
        $userName  = 'Meo';
        $userPass  = '123321';

        $user = new User();
        $user->setLogin($userLogin);
        $user->setName($userName);
        $user->setPassword(password_hash($userPass, PASSWORD_BCRYPT));
        $user->setRegDate(new \DateTime());
        $dcManager = $this->getDoctrine()->getManager();

        $dcManager->persist($user);
        try {
            $dcManager->flush();
        } catch (UniqueConstraintViolationException $e) {
            return new Response('Пользователь с логином ' . $userLogin . ' уже существует');
        }

        return new Response('Добавлен пользователь ' . $userLogin . ' с паролем ' . $userPass);
    }

}