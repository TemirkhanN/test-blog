<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Comment;
use BlogBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class CommentController
 * @package BlogBundle\Controller
 */
class CommentController extends Controller
{

    /**
     * Добавление комментария к публикации
     *
     * @param int $postId
     * @param Request $request
     *
     * @return Response|RedirectResponse
     * @throws AccessDeniedException
     * @throws NotFoundHttpException
     */
    public function createCommentAction($postId, Request $request)
    {
        $session = new Session();
        if (!$session->has('user_info')) {
            throw $this->createAccessDeniedException('Комментарии могут оставлять только авторизованные пользователи');
        }

        $post = $this->getDoctrine()->getRepository('BlogBundle:Post')->find($postId);
        if(!$post){
            throw $this->createNotFoundException('Публикации, к которой вы пытаетесь добавить комментарий, не существует');
        }

        $comment     = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setPost($post);
            $author = $this->getDoctrine()->getRepository('BlogBundle:User')->find($session->get('user_info')->getId());
            $comment->setAuthor($author);
            $comment->setPubDate(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            if($comment->getId()){
                return $this->redirect($this->generateUrl('blog_post', ['postId' => $postId]));
            }
            $session->getFlashBag()->set('error', 'Не удалось добавить комментарий');
        }

        return $this->render('BlogBundle:comment:item-form.html.twig', [
            'commentForm' => $commentForm->createView()
        ]);

    }

}