<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Model\Todo;

class TodoController extends Controller
{
    public function indexAction() : Response
    {
        $todos = $this->get('doctrine')->getManager()->getRepository(Todo::class)->findAll();

        return $this->render('@App/Resources/views/Todo/index.html.twig', [
            'todos' => $todos,
        ]);
    }
}
