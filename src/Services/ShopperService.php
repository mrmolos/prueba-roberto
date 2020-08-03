<?php


namespace App\Services;




use App\Repository\AddressRepository;
use App\Repository\CartProductRepository;
use App\Repository\ShopperRepository;
use App\Repository\ShopRepository;
use App\Repository\UserRepository;
use App\Repository\ProductCatalogRepository;
use App\Repository\CartRepository;

use Doctrine\ORM\EntityManagerInterface;





use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShopperService
{
    protected AddressRepository $addressRepository;
    protected UserRepository $userRepository;
    protected ShopRepository $shopRepository;
    protected ShopperRepository $shopperRepository;
    protected CartProductRepository $cartProductRepository;
    protected ProductCatalogRepository $productCatalogRepository;
    protected CartRepository $cartRepository;
    protected EntityManagerInterface $entityManager;

    public function __construct(UserRepository $userRepository,
                                AddressRepository $addressRepository,
                                ShopRepository $shopRepository,
                                ShopperRepository $shopperRepository,
                                CartProductRepository $cartProductRepository,
                                ProductCatalogRepository $productCatalogRepository,
                                CartRepository $cartRepository,
                                EntityManagerInterface $entityManager
    )
    {
        $this->addressRepository = $addressRepository;
        $this->userRepository = $userRepository;
        $this->shopRepository = $shopRepository;
        $this->shopperRepository = $shopperRepository;
        $this->cartProductRepository = $cartProductRepository;
        $this->productCatalogRepository = $productCatalogRepository;
        $this->entityManager = $entityManager;
        $this->cartRepository = $cartRepository;

    }


    public function getOrder($shop_id, $shopper_id){
        //Obtengo tienda. Si no existe manda error
        $shop = $this->shopRepository->find($shop_id);
        if(!$shop){
            throw new NotFoundHttpException("SHOP NOT FOUND");
        }

        //Obtengo el shopper. Si no existe manda error
        $shopper = $this->shopperRepository->find($shopper_id);
        if(!$shopper){
            throw new NotFoundHttpException("SHOPPER NOT FOUND");
        }

        //Obtener carro
        //Se usa el método findoneby porque en este caso solo va a haber un carro asignado a un shopper a la vez
        $cart= $this->cartRepository->findOneBy([
            'shopper' =>$shopper->getId(),
            'shop' => $shop->getId()
        ]);
        //Si no hay carros manda error
        if(!$cart){
            throw new NotFoundHttpException("CART NOT FOUND");
        }

        //Obtener líneas de carro
        $lines = $this->cartProductRepository->findBy(['Cart' => $cart]);

        //Ya tenemos todos los datos necesarios desde la bd. Ahora solo falta construir una respuesta json que enviar al controlador

        $response = $this->createOrderDetails($shop, $shopper, $cart, $lines);

        return $response;

    }

    public function createOrderDetails ($shop, $shopper, $cart, $lines){
        //En esta función creo un objeto json con los detalles que recibe el shopper

        $orderlines = [];
        foreach ($lines as $line){
            $lineDetail = [
                'Producto' => $line->getProductId()->getName(),
                'Cantidad' => $line->getQuantity(),
                'Precio' => $line->getProductId()->getPrice()
            ];
            $orderlines[] = $lineDetail;
        }

        $orderDetails = [
            'shopper' => [
                'id' => $shopper->getId(),
                'name' => $shopper->getName()
            ],
            'shop' => [
                'id' => $shop->getId(),
                'name' => $shop->getName()
            ],
            'order' => $orderlines,
            'total' => $cart->getTotal(),
            'delivery' => [
                'deliveryDate' => $cart->getDeliveryDate(),
                'deliveryStart' => $cart->getDeliveryStart(),
                'deliveryEnd' => $cart->getDeliveryEnd(),
                'Address' => $cart->getAddressId()->getAddress()
            ]
        ];

        return $orderDetails;
    }

}