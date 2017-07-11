<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Model\Todo;
use App\Form\Type\CreateTodo;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Model\Item;
use App\Form\Type\CreateItem;

class TodoController extends Controller
{
    public function indexAction(Request $request) : Response
    {
        if ('' !== $q = $request->query->get('q', '')) {
            $todos = $this->get('doctrine')->getManager()->getRepository(Todo::class)->findByName($q);
        } else {
            $todos = $this->get('doctrine')->getManager()->getRepository(Todo::class)->findAll();
        }

        return $this->render('@App/Resources/views/Todo/index.html.twig', [
            'todos' => $todos,
        ]);
    }

    public function createTodoAction(Request $request) : Response
    {
        $todo = Todo::fromArray();

        $form = $this->createForm(CreateTodo::class, $todo);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine')->getManager();

            $em->persist($form->getData());
            $em->flush();

            $this->addFlash('success', sprintf(
                'La todo %s a bien été créee',
                $todo->getName()
            ));

            return $this->redirectToRoute('app_todo_index');
        }

        return $this->render('@App/Resources/views/Todo/create-todo.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function addItemAction(Request $request, $todoId) : Response
    {
        $todo = $this->get('doctrine')->getManager()->getRepository(Todo::class)->find($todoId);

        if (null === $todo) {
            throw new NotFoundHttpException();
        }

        $item = Item::fromArray(['todo' => $todo]);

        $form = $this->createForm(CreateItem::class, $item);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine')->getManager();

            $em->persist($form->getData());
            $em->flush();

            $this->addFlash('success', sprintf(
                'L\'item %s a bien été ajouté à la todo %s',
                $item->getName(),
                $todo->getName()
            ));

            return $this->redirectToRoute('app_todo_index');
        }

        return $this->render('@App/Resources/views/Todo/create-item.html.twig', [
            'form' => $form->createView(),
            'todo' => $todo
        ]);
    }
}
