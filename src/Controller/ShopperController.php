<?php


namespace App\Controller;


use App\Services\ShopperService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ShopperController extends AbstractController
{

    /**
     * @Route("/shopper/{shopper_id}/{shop_id}", name="shopperRequest", methods ={"GET"})
     * @param $shopper_id
     * @param $shop_id
     * @param ShopperService $shopperService
     * @return JsonResponse
     */
    public function shopperCarts($shopper_id, $shop_id, ShopperService $shopperService)
    {
        $response = $shopperService->getOrder($shop_id, $shopper_id);

        return new JsonResponse(['Request Details' => $response]);
    }

}