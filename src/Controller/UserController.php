<?php


namespace App\Controller;


use App\Services\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{

    /**
     * @Route("/clientorder", name="clientOrder", methods={"POST"})
     * @param Request $request
     * @param OrderService $order
     * @return JsonResponse
     */
     public function clientOrder(Request $request, OrderService $order)
    {

        $data = json_decode($request->getContent(), true);

        $response=$order->createOrder($data);

        return new JsonResponse($response);

    }

}