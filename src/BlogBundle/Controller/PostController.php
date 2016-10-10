<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Post;
use BlogBundle\Entity\User;
use BlogBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class PostController
 * @package BlogBundle\Controller
 */
class PostController extends Controller
{

    /**
     * Список всех опубликованных публикаций
     *
     * @param int     $page
     * @param Request $request
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function indexAction($page, Request $request)
    {
        $onPage = $request->query->get('onPage') ?: 5; // Если вдруг понадобится ограничить вывод на страницу другим числом

        $posts = $this->getDoctrine()->getRepository('BlogBundle:Post')->getPosts(['status' => Post::STATUS_PUBLISHED], $page, $onPage);
        if ($posts->count() === 0) {
            throw $this->createNotFoundException();
        }

        return $this->render('BlogBundle:post:common-list.html.twig', [
            'posts'        => $posts,
            'onPage'       => $onPage,
            'currentPage'  => $page,
            'totalResults' => $posts->count()
        ]);
    }


    /**
     * Список всех публикаций пользователя
     *
     * @param int     $authorId
     * @param int     $page
     * @param Request $request
     *
     * @return Response
     */
    public function getAuthorContentsAction($authorId, $page, Request $request)
    {
        $onPage = $request->query->get('onPage') ?: 5; // Если вдруг понадобится ограничить вывод на страницу другим числом

        $criteria = [
            'author' => $authorId,
            'status' => Post::STATUS_PUBLISHED
        ];

        $session = new Session();
        if ($session->has('user_info')) {
            $user = $session->get('user_info');

            //Для самого автора, который просматривает список собственных публикаций, снимаем ограничение на статус публикации
            if ($user->getId() === $authorId) {
                unset($criteria['status']);
            }
        }

        $posts = $this->getDoctrine()->getRepository('BlogBundle:Post')->getPosts($criteria, $page, $onPage, 'addDate', 'DESC');

        return $this->render('BlogBundle:post:author-list.html.twig', [
            'posts'        => $posts,
            'onPage'       => $onPage,
            'currentPage'  => $page,
            'totalResults' => $posts->count()
        ]);
    }


    /**
     * Добавление новой публикации
     *
     * @param Request $request
     *
     * @return  Response
     */
    public function createContentAction(Request $request)
    {
        $session = new Session();
        if (!$session->has('user_info')) {
            throw $this->createAccessDeniedException('Комментарии могут оставлять только авторизованные пользователи');
        }

        $author = $this->getDoctrine()
            ->getManager()
            ->getRepository('BlogBundle:User')
            ->find($session->get('user_info')->getId());

        $postForm = $this->createForm(PostType::class, new Post());
        $postForm->handleRequest($request);

        if ($postForm->isSubmitted() && $postForm->isValid()) {
            $post = $postForm->getData();
            $post->setAuthor($author);
            $post->setAddDate(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            if ($post->getId()) {
                return $this->redirect(
                    $this->generateUrl('blog_post', [
                        'postId' => $post->getId()
                    ])
                );
            }

            $session->getFlashBag()->set('error', 'Произошла ошибка при создании публикации');
        }

        return $this->render('BlogBundle:post:item-form.html.twig', [
            'postForm' => $postForm->createView()
        ]);
    }

    /**
     * Просмотр публикации
     *
     * @param int $postId
     *
     * @return Response
     */
    public function getContentAction($postId)
    {
        if (($post = $this->getDoctrine()->getRepository('BlogBundle:Post')->getPost($postId)) === null) {
            throw $this->createNotFoundException('К сожалению, такой публикации не существует');
        }

        /**
         * @var User $user
         * @var Post $post
         */

        $isOwner     = false;
        $commentForm = null; //Форма комментирования для авторизованных пользователей

        $session = new Session();
        if ($session->has('user_info')) {
            $user    = $session->get('user_info');
            $isOwner = (int)$user->getId() === (int)$post->getAuthor()->getId();
        }


        //Если публикация не опубликована,проверяем, что ее просматривает владелец
        if (!$isOwner && $post->getStatus() !== Post::STATUS_PUBLISHED) {
            throw $this->createNotFoundException('К сожалению, такой публикации не существует');
        }

        return $this->render('BlogBundle:post:common-item.html.twig', [
            'post'    => $post,
            'isOwner' => $isOwner
        ]);
    }

    /**
     * Редактирование публикации
     *
     * @param int     $postId
     * @param Request $request
     *
     * @return Response
     * @throws NotFoundHttpException
     * @throws AccessDeniedException
     */
    public function updateContentAction($postId, Request $request)
    {
        /* TODO логика проверки авторизации и прав на доступ к публикации нарушает принцип DRY. Найти способ сделать это "правильно"
         * скорее всего проблема решится при разрешении TODO из @see UserController::loginAction()
         */
        $session = new Session();
        if (!$session->has('user_info')) {
            throw $this->createAccessDeniedException('Редактирование доступно только авторизованным пользователям');
        }
        $user = $session->get('user_info');
        $post = $this->getDoctrine()->getRepository('BlogBundle:Post')->findOneBy(['id' => $postId, 'author' => $user]);
        if ($post === null) {
            throw $this->createNotFoundException('К сожалению, такой публикации не существует');
        }

        $postForm = $this->createForm(PostType::class, $post);
        $postForm->handleRequest($request);
        if ($postForm->isSubmitted() && $postForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            if ($post->getId()) {
                return $this->redirect(
                    $this->generateUrl('blog_post', [
                        'postId' => $post->getId()
                    ])
                );
            }

            $session->getFlashBag()->set('error', 'Произошла ошибка при сохранении данных');
        }

        return $this->render('BlogBundle:post:item-form.html.twig', [
            'postForm' => $postForm->createView()
        ]);
    }

    /**
     * Изменяет статус публикации на "опубликовано"
     *
     * @param         $postId
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function publishContentAction($postId, Request $request)
    {
        $session = new Session();
        if (!$session->has('user_info')) {
            throw $this->createAccessDeniedException('Вы не можете удалять публикации');
        }

        $user = $session->get('user_info');
        $post = $this->getDoctrine()->getRepository('BlogBundle:Post')->findOneBy(['id' => $postId, 'author' => $user]);
        if ($post === null) {
            throw $this->createNotFoundException('К сожалению, такой публикации не существует');
        }

        if ($post->getStatus() === Post::STATUS_PUBLISHED) {
            return $this->redirect($request->headers->get('referer'));
        }

        $post->setStatus(Post::STATUS_PUBLISHED);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($post);
        $entityManager->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Удаление публикации
     *
     * @param int     $postId
     *
     * @return Response|RedirectResponse
     */
    public function deleteContentAction($postId)
    {
        $session = new Session();
        if (!$session->has('user_info')) {
            throw $this->createAccessDeniedException('Вы не можете удалять публикации');
        }

        $user = $session->get('user_info');
        $post = $this->getDoctrine()->getRepository('BlogBundle:Post')->findOneBy(['id' => $postId, 'author' => $user]);

        if ($post === null) {
            throw $this->createNotFoundException('К сожалению, такой публикации не существует');
        }

        if ($post->getStatus() === Post::STATUS_PUBLISHED) {
            return $this->createAccessDeniedException('Нельзя удалять опубликованные посты');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirect($this->generateUrl('blog_posts'));
    }
}