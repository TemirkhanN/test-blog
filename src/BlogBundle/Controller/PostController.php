<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Post;
use BlogBundle\Entity\User;
use BlogBundle\Form\PostType;
use BlogBundle\Service\AuthManager;
use BlogBundle\Service\PostManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Контроллер для манипуляций с публикациями
 */
class PostController extends AbstractController
{
    /**
     * Сервис публикаций
     *
     * @var PostManager
     */
    private $postManager;

    /**
     * Сервис авторизации
     *
     * @var AuthManager
     */
    private $authManager;

    /**
     * Фабрика форм
     *
     * @var FormFactory
     */
    private $formFactory;

    /**
     * Конструктор
     *
     * @param EngineInterface $engine
     * @param PostManager     $postManager
     * @param AuthManager     $authManager
     * @param FormFactory     $formFactory
     */
    public function __construct(
        EngineInterface $engine,
        PostManager $postManager,
        AuthManager $authManager,
        FormFactory $formFactory
    )
    {
        $this->setRenderer($engine);
        $this->postManager = $postManager;
        $this->authManager = $authManager;
        $this->formFactory = $formFactory;
    }

    /**
     * Список всех опубликованных записей
     *
     * @param int $page
     * @param int $onPage
     *
     * @return Response
     */
    public function indexAction(int $page, int $onPage): Response
    {
        $posts = $this->postManager->getPosts($page, $onPage);

        if ($posts->count() === 0) {
            return $this->respondNotFound('Публикации не найдены');
        }

        return $this->respond(
            'BlogBundle:post:common-list.html.twig',
            [
                'posts'       => $posts,
                'onPage'      => $onPage,
                'currentPage' => $page,
                'total'       => $posts->count(),
            ]
        );
    }


    /**
     * Список всех публикаций пользователя
     *
     * @param User $author
     * @param int  $page
     * @param int  $onPage
     *
     * @return Response
     */
    public function getAuthorContentsAction(User $author, int $page, int $onPage)
    {
        $user = $this->authManager->getUser();

        if ($user->getId() === $author->getId()){
            $posts = $this->postManager->getPostsByAuthor($author, $page, $onPage);
        } else {
            $posts = $this->postManager->getPublishedPostsByAuthor($author, $page, $onPage);
        }

        return $this->respond(
            'BlogBundle:post:author-list.html.twig',
            [
                'author'      => $author,
                'posts'       => $posts,
                'onPage'      => $onPage,
                'currentPage' => $page,
                'total'       => $posts->count(),
            ]
        );
    }

    /**
     * Просмотр публикации
     *
     * @param Post $post
     *
     * @Extra\Security("is_granted('view', post)")
     *
     * @return Response
     */
    public function getContentAction(Post $post)
    {
        $user    = $this->authManager->getUser();
        $isOwner = $user && $user->getId() === $post->getAuthor()->getId();

        //Если публикация не опубликована,проверяем, что ее просматривает владелец
        if (!$isOwner && $post->getStatus() !== Post::STATUS_PUBLISHED) {
            $this->respondNotFound('К сожалению, такой публикации не существует');
        }

        return $this->respond('BlogBundle:post:common-item.html.twig', [
            'post'    => $post,
            'is_owner' => $isOwner,
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
        $author = $this->authManager->getUser();
        if (!$author) {
            return $this->respondAccessForbidden('Создавать публикации могут лишь авторизованные пользователи');
        }

        $postForm = $this->formFactory->create(PostType::class);
        $postForm->handleRequest($request);

        if ($postForm->isSubmitted() && $postForm->isValid()) {
            $post = $this->postManager->addPost($postForm->getData(), $author);

            if ($post->getId()) {
                return new RedirectResponse($this->postManager->getPostPageLink($post));
            }

            (new Session())
                ->getFlashBag()
                ->set('error', 'Произошла ошибка при создании публикации');
        }

        return $this->respond('BlogBundle:post:item-form.html.twig', ['postForm' => $postForm->createView()]);
    }

    /**
     * Редактирование публикации
     *
     * @param int     $postId
     * @param Request $request
     *
     * @return Response
     */
    public function updateContentAction($postId, Request $request)
    {
        /* TODO логика проверки авторизации и прав на доступ к публикации нарушает принцип DRY. Найти способ сделать это "правильно"
         * скорее всего проблема решится при разрешении TODO из @see UserController::loginAction()
         */
        $session = new Session();
        if (!$session->has('user_info')) {
            return $this->respondAccessForbidden('Редактирование доступно только авторизованным пользователям');
        }
        $user = $session->get('user_info');
        $post = $this->getDoctrine()->getRepository('BlogBundle:Post')->findOneBy(['id' => $postId, 'author' => $user]);
        if ($post === null) {
            return $this->respondNotFound('К сожалению, такой публикации не существует');
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
                        'postId' => $post->getId(),
                    ])
                );
            }

            $session->getFlashBag()->set('error', 'Произошла ошибка при сохранении данных');
        }

        return $this->render('BlogBundle:post:item-form.html.twig', [
            'postForm'     => $postForm->createView(),
            'existingItem' => true,
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
     * @param int $postId
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