<?php


namespace App\Services;



use App\Entity\Cart;
use App\Entity\CartProduct;


use App\Repository\AddressRepository;
use App\Repository\CartProductRepository;
use App\Repository\ShopperRepository;
use App\Repository\ShopRepository;
use App\Repository\UserRepository;
use App\Repository\ProductCatalogRepository;

use Doctrine\ORM\EntityManagerInterface;

use \DateTime;



use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class OrderService
{
    protected AddressRepository $addressRepository;
    protected UserRepository $userRepository;
    protected ShopRepository $shopRepository;
    protected ShopperRepository $shopperRepository;
    protected CartProductRepository $cartProductRepository;
    protected ProductCatalogRepository $productCatalogRepository;
    protected EntityManagerInterface $entityManager;

    public function __construct(UserRepository $userRepository,
                                AddressRepository $addressRepository,
                                ShopRepository $shopRepository,
                                ShopperRepository $shopperRepository,
                                CartProductRepository $cartProductRepository,
                                ProductCatalogRepository $productCatalogRepository,
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

    }


    public function createOrder($order){


        //Obtener usuario, dirección, tienda y shopper
        $user = $this->userRepository->find($order['user']);//LO PILLA
        if(!$user){
            throw new NotFoundHttpException('USER NOT FOUND');
        }
        $address = $this->addressRepository->find($order['address']);//LO PILLA
        if(!$address){
            throw new NotFoundHttpException('ADDRESS NOT FOUND');
        }
        $shop = $this->shopRepository->find($order['shop']);//LO PILLA
        if(!$address){
            throw new NotFoundHttpException('SHOP NOT FOUND');
        }
        $shopper = $this->shopperRepository
            ->findOneBy([
                'shop' => $shop->getId(),
                'status' => 'STOPPED'
            ]);//LO PILLA
        if(!$shopper){
            throw new NotFoundHttpException('SHOPPER NOT FOUND');
        }

        //Fechas
        $deliveryDate = $order['delivery']['deliveryDate'];
        $date = DateTime::createFromFormat('Y-m-d', $deliveryDate);
        $deliveryStart = $order['delivery']['deliveryStart'];
        $dateStart =  DateTime::createFromFormat('Y-m-d H:i:s', $deliveryStart);
        $deliveryEnd = $order['delivery']['deliveryEnd'];
        $dateEnd =DateTime::createFromFormat('Y-m-d H:i:s', $deliveryEnd);




        //Creacion del carro
        $cart = new Cart();
        $cart->setUserId($user)
            ->setAddressId($address)
            ->setShopId($shop)
            ->setDeliveryDate($date)
            ->setDeliveryStart($dateStart)
            ->setDeliveryEnd($dateEnd)
            ->setStatus('WAITING')
            ->setBuyDate(new DateTime('now'))
            ->setShopperId($shopper);// FALTA EL TOTAL


        //Gestion dato de las lineas de producto
        //Es un vector con varias lineas de producto, cada línea debe ser subida a la base de datos
        $productLines = $order['order'];//Recibe vector con los productos
        $lines = [];//array de objetos CartProduct para subir a la bd
        $lineOrder = []; //Array para guardar cantidad y precio
        foreach ($productLines as $productLine){
            $product = $this->productCatalogRepository->find($productLine['product']);
            $line = new CartProduct();
            $line->setProductId($product)
                ->setQuantity($productLine['quantity'])
                ->setCartId($cart);
            $lines[] = $line;
            $lineOrder[] = ['quantity' => $productLine['quantity'], 'price' => $product->getPrice()];
        }


        //Obtener total para el carro
        $total = $this->getTotal($lineOrder);
        $cart->setTotal($total);



        if ($cart){
            //Cambiar estado del shopper
            $shopper->setStatus('WORKING');
            $this->entityManager->persist($shopper);

            $this->entityManager->persist($cart);
            $this->entityManager->flush();
            $message = [
                'Status' => 'OK',
                'Message' => 'Compra realizada con exito'
            ];
        } else {
            $message =[
                'Status' => 'FAIL',
                'Message' => 'Hubo un problema'
            ];
        }

        //Volcar líneas de carro en la base de datos
        foreach ($lines as $line){
            $this->entityManager->persist($line);
            $this->entityManager->flush();
        }

        return $message;

    }

    public function getTotal($lines){
        $total = 0;
        foreach ($lines as $line){
            $lineTotal = $line['price'] * $line['quantity'];
            $total += $lineTotal;
        }
        return $total;
    }


    /*
     Futuras funciones:
    1-Obtener shopper en función del status
    2-Funcion para obtener las lineas de producto cantidad y precio
    3-Funcion para obtener el total
    4-Funcion para hacer subida a bd
    5-Validaciones y estructuras de control
    6-Return a la base de datos
    7-Volcar con try catch para poder gestionar un posible error
     */

}