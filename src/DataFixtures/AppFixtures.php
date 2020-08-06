<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\ProductCatalog;
use App\Entity\Shop;
use App\Entity\Shopper;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        //Usuarios y direcciones
        for ($i=1; $i<4; $i++) {

            $user = new User();
            $user->setName('name ' . $i)
                ->setSurname('surname ' . $i)
                ->setEmail('email' . $i . '@gmail.com')
                ->setPhone('11223' . $i)
                ->setDateCreated(new DateTime('now'))
                ->setDateUpdated(new DateTime('now'));


            $address = new Address();
            $address->setAddress('Sesame Street, ' . $i)
                ->setPostalNumber('28470')
                ->setUser($user);

            $manager->persist($user);
            $manager->persist($address);

        }

            //Tiendas, productos y shoppers
            //El shopper va asociado a una única tienda
            $shops = ['lidl', 'carrefour', 'alcampo'];
            $shoppers = ['fer', 'alejo', 'miguel'];

            for ($i=1; $i<4; $i++){
                $shop = new Shop();
                $shop->setName($shops[$i-1])
                    ->setAddress('address ' . $i)
                    ->setDescription('Descripcion de la tienda ' . $i);

                $shopper = new Shopper();
                $shopper->setName($shoppers[$i-1])
                    ->setStatus('STOPPED')
                    ->setShop($shop);

                $manager->persist($shop);
                $manager->persist($shopper);

                $products = [
                    'jamon' => 4.15,
                    'tomate' => 1.25,
                    'peras' => 3.30,
                    'patatas' => 4.8,
                    'pasta' => 2.60
                ];
                foreach ($products as $productName => $price){
                    $product = new ProductCatalog();
                    $product->setName($productName)
                        ->setDescription('Descripcion del producto')
                        ->setPrice($price)
                        ->setShop($shop);

                    $manager->persist($product);
                }
            }

        $manager->flush();

    }
}
