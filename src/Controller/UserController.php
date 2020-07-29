<?php


namespace App\Controller;

use App\Entity\User;

use LogicException;
use PhpParser\Node\Expr\New_;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




class UserController extends AbstractController
{

    //CONTROLADOR USER CODIGO PRUEBA
    /**
     * @Route("/new", name="userpage", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $nombre = $data['nombre'];

        return new JsonResponse(['RESULT' =>'OK', 'data' => $nombre]);
    }


}