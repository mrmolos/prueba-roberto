<?php


namespace App\Controller;


use App\Services\ShopperService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ShopperController extends AbstractController
{
//CONTROLADOR PARA EL SHOPPER
//LA RUTA DEBE CONTENER DOS PARAMETROS: EL ID DEL SHOPPER Y EL DE LA TIENDA
//LA RESPUESTA DEBE SER UN JSON CON LA INFORMACIÓN COMPLETA DEL PEDIDO
    /**
     * @Route("/shopper/{shopper_id}/{shop_id}", methods ={"GET"})
     * @param $shopper_id
     * @param $shop_id
     * @param ShopperService $shopperService
     * @return JsonResponse
     */
public function shopperCarts($shopper_id, $shop_id, ShopperService $shopperService){

    $response = $shopperService->getOrder($shop_id, $shopper_id);

    return new JsonResponse(['Detalles del pedido' => $response]);
}


}