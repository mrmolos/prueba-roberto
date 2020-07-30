<?php


namespace App\Services;


use App\Entity\Cart;

use App\Repository\AddressRepository;
use App\Repository\ShopperRepository;
use App\Repository\ShopRepository;
use App\Repository\UserRepository;
use \DateTime;


class OrderService
{
    protected AddressRepository $addressRepository;
    protected UserRepository $userRepository;
    protected ShopRepository $shopRepository;
    protected ShopperRepository $shopperRepository;

    public function __construct(UserRepository $userRepository,
                                AddressRepository $addressRepository,
                                ShopRepository $shopRepository,
                                ShopperRepository $shopperRepository)
    {
        $this->addressRepository = $addressRepository;
        $this->userRepository = $userRepository;
        $this->shopRepository = $shopRepository;
        $this->shopperRepository = $shopperRepository;
    }


    public function createOrder($order){

        $user = $this->userRepository->find($order['user']);
        $address = $this->addressRepository->find($order['address']);
        $shop = $this->shopRepository->find($order['shop']);
        $shopper = $this->shopperRepository->findOneBy(['shop' => $shop->getId()]);

        //Creacion del carro
        $cart = new Cart();
        $cart->setUserId($user)
            ->setAddressId($address)
            ->setShopId($shop)
            ->setDeliveryDate(new DateTime('now'))
            ->setDeliveryStart(new DateTime('now'))
            ->setDeliveryEnd(new DateTime('now'))
            ->setStatus('WAITING')

            ->setShopperId($shopper)
            ->setTotal(1200);

        return $cart;

    }

    /*
     Futuras funciones:
    1-Obtener shopper en función del status
    2-Funcion para obtener las lineas de producto cantidad y precio
    3-Funcion para obtener el total
    4-Funcion para hacer subida a bd
    5-Validaciones y estructuras de control
    6-Return a la base de datos
     */


}