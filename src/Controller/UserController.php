<?php


namespace App\Controller;


use App\Services\OrderService;
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
     * @param OrderService $order
     * @return JsonResponse
     */
     public function show(Request $request, OrderService $order)
    {
        //Acceso al objeto JSON
        $data = json_decode($request->getContent(), true);


        $response=$order->createOrder($data);

/*
        $cartData = [
          'user' => $cart->getUserId(),
          'direccion' => $cart->getAddressId(),
          'tienda' => $cart->getShopId(),
            'shopper' => $cart->getShopperId(),
            'Fecha compra' => $cart->getBuyDate(),
            'hora inicio' => $cart->getDeliveryStart(),
            'hora final' => $cart->getDeliveryEnd(),
            'status' => $cart->getStatus(),
            'total compra' => $cart->getTotal()
        ];
        $direccionprueba = $cart->getAddressId()->getAddress();
        $response = ['nombre de la calle' => $direccionprueba];*/



       return new JsonResponse($response);

    }






}