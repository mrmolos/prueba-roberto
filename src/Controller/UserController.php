<?php


namespace App\Controller;

use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{

    //CONTROLADOR USER CODIGO PRUEBA
    /**
     * @Route("/", name="userpage")
     */
    public function show()
    {

        return new Response('Hola desde el controlador');
    }


}