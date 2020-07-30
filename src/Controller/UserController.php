<?php


namespace App\Controller;

use App\Entity\User;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;





class UserController extends AbstractController
{

    //CONTROLADOR USER CODIGO PRUEBA
    /**
     * @Route("/users")
     * @param Request $request
     * @return JsonResponse
     */
     public function show(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $nombre = $data['nombre'];

       return new JsonResponse(['RESULT' =>'OK', 'data' => $nombre]);

    }

    /**
     * @Route("/nueva", name="nueva")
     * @return Response
     */
     public function user(){
        return new JsonResponse(['hola' =>'hola']);
    }


}