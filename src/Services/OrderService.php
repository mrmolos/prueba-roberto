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


    public function createOrder($order)
    {

        //Obteniendo usuario, dirección, tienda y shopper
        $user = $this->userRepository->find($order['user']);
        if(!$user){
            throw new NotFoundHttpException('USER NOT FOUND');
        }
        $address = $this->addressRepository->find($order['address']);
        if(!$address){
            throw new NotFoundHttpException('ADDRESS NOT FOUND');
        }
        $shop = $this->shopRepository->find($order['shop']);
        if(!$address){
            throw new NotFoundHttpException('SHOP NOT FOUND');
        }
        $shopper = $this->shopperRepository
            ->findOneBy([
                'shop' => $shop->getId(),
                'status' => 'STOPPED'
            ]);
        if(!$shopper){
            throw new NotFoundHttpException('SHOPPER NOT FOUND');
        }

        //Fechas
        $delivery= $order['delivery']['deliveryDate'];
        $deliveryDate = DateTime::createFromFormat('Y-m-d', $delivery);
        $deliveryStart = $order['delivery']['deliveryStart'];
        $dateStart =  DateTime::createFromFormat('Y-m-d H:i:s', $deliveryStart);
        $deliveryEnd = $order['delivery']['deliveryEnd'];
        $dateEnd =DateTime::createFromFormat('Y-m-d H:i:s', $deliveryEnd);


        //Creacion del carro
        $cart = new Cart();
        $cart->setUser($user)
            ->setAddress($address)
            ->setShop($shop)
            ->setDeliveryDate($deliveryDate)
            ->setDeliveryStart($dateStart)
            ->setDeliveryEnd($dateEnd)
            ->setStatus('WAITING')
            ->setBuyDate(new DateTime('now'))
            ->setShopper($shopper);


        //Gestion de los CartProduct
        $productLines = $order['order'];//Recibe vector con los productos
        $totalPrice = 0;
        foreach ($productLines as $productLine){
            $product = $this->productCatalogRepository->find($productLine['product']);
            $line = new CartProduct();
            $line->setProduct($product)
                ->setQuantity($productLine['quantity'])
                ->setCart($cart);
            $this->entityManager->persist($line);

            $totalPrice += $product->getPrice() * $line->getQuantity();// Precio total del carro
        }

        //Obtener total para el carro
        $cart->setTotal($totalPrice);


        if ($cart){
            //Cambiar estado del shopper
            $shopper->setStatus('WORKING');
            $this->entityManager->persist($cart);
            $this->entityManager->flush();
            $message = [
                'Status' => true,
                'Message' => 'Purchase made successfully'
            ];
        } else {
            $message =[
                'Status' => false,
                'Message' => 'Something went wrong'
            ];
        }

        return $message;
    }

}