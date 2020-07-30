<?php


namespace App\Controller;




use App\Entity\Address;
use App\Entity\User;
use App\Repository\AddressRepository;
use App\Repository\UserRepository;
use App\Services\OrderService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;






class UserController extends AbstractController
{

    //CONTROLADOR USER CODIGO PRUEBA
    /**
     * @Route("/clientorder", methods={"POST"})
     * @param Request $request
     * @param UserRepository $userRepository
     * @param OrderService $order
     * @return JsonResponse
     */
     public function show(Request $request, UserRepository $userRepository, OrderService $order)
    {
        $data = json_decode($request->getContent(), true);

     /*
        $id = $data['user'];
        $user = $userRepository->findOneBy(['id' => $id]);
        if(!$user){
            $response = ['status' => 'FAIL'];
        }
        else {
            $name = $user->getName();
            $response = ['status' => 'GOOD', 'nombre' => $name];
        }*/


        $cart=$order->createOrder($data);
        $total = $cart->getTotal();
        $mensaje = ['total compra' => $total];

       return new JsonResponse($total);

    }






}