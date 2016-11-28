<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FixtureLoader implements FixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    public function load(ObjectManager $manager)
    {

        $category_1 = new Category();
        $category_1->setName('Auto');
        $category_1->setIsActive(true);
        $category_1->setProducts(null);
        $category_1->setParent();


        $category_2 = new Category();
        $category_2->setName('Peugeot');
        $category_2->setIsActive(true);
        $category_2->setProducts(null);
        $category_2->setParent($category_1);

        $category_3 = new Category();
        $category_3->setName('Audi');
        $category_3->setIsActive(true);
        $category_3->setProducts(null);
        $category_3->setParent($category_1);

        $category_4 = new Category();
        $category_4->setName('Motocycles');
        $category_4->setIsActive(true);
        $category_4->setProducts(null);
        $category_4->setParent();

        $category_5 = new Category();
        $category_5->setName('Harley Davidson');
        $category_5->setIsActive(true);
        $category_5->setProducts(null);
        $category_5->setParent($category_4);

        $category_6 = new Category();
        $category_6->setName('Light');
        $category_6->setIsActive(true);
        $category_6->setProducts(null);
        $category_6->setParent($category_5);

        $category_7 = new Category();
        $category_7->setName('Yamaha');
        $category_7->setIsActive(true);
        $category_7->setProducts(null);
        $category_7->setParent($category_4);

        $category_8 = new Category();
        $category_8->setName('Smartphones');
        $category_8->setIsActive(true);
        $category_8->setProducts(null);
        $category_8->setParent();

        $category_9 = new Category();
        $category_9->setName('iPhone');
        $category_9->setIsActive(true);
        $category_9->setProducts(null);
        $category_9->setParent($category_8);

        $category_10 = new Category();
        $category_10->setName('Samsung');
        $category_10->setIsActive(true);
        $category_10->setProducts(null);
        $category_10->setParent($category_8);

        $user_1 = new User();
        $user_1->setUsername('Mary');
        $user_1->setEmail('m@mail.ru');
        $user_1->setPlainPassword('11111111');
        $user_1->setIsActive(true);
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user_1, $user_1->getPlainPassword());
        $user_1->setPassword($password);

        $user_2 = new User();
        $user_2->setUsername('Vita');
        $user_2->setEmail('v@mail.ru');
        $user_2->setPlainPassword('11111111');
        $user_2->setIsActive(true);
        $user_2->addRoles('ROLE_MANAGER');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user_2, $user_2->getPlainPassword());
        $user_2->setPassword($password);

        $user_3 = new User();
        $user_3->setUsername('Grisha');
        $user_3->setEmail('g@mail.ru');
        $user_3->setPlainPassword('11111111');
        $user_3->setIsActive(true);
        $user_3->addRoles('ROLE_ADMIN');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user_3, $user_3->getPlainPassword());
        $user_3->setPassword($password);

        $product_1 = new Product();
        $product_1->setName('Yamaha 2014 MX245');
        $product_1->setSKU('234522312334');
        $product_1->setDescription('Хороший мот');
        $product_1->setCategory($category_7);

        $product_2 = new Product();
        $product_2->setName('Audi 80 2016 mx');
        $product_2->setSKU('234523123234');
        $product_2->setDescription('Mega car');
        $product_2->setCategory($category_3);

        $product_3 = new Product();
        $product_3->setName('Audi 100 2015 mx');
        $product_3->setSKU('234234523234');
        $product_3->setDescription('Mega super');
        $product_3->setCategory($category_3);

        $product_4 = new Product();
        $product_4->setName('Peugeot 806 HDI');
        $product_4->setSKU('23239834753');
        $product_4->setDescription('Big car');
        $product_4->setCategory($category_2);

        $product_5 = new Product();
        $product_5->setName('Peugeot 406 HDI');
        $product_5->setSKU('23234523334');
        $product_5->setDescription('Big car');
        $product_5->setCategory($category_2);

        $product_6 = new Product();
        $product_6->setName('Harley 7378 34');
        $product_6->setSKU('23233793282');
        $product_6->setDescription('Big moto');
        $product_6->setCategory($category_6);

        $product_7 = new Product();
        $product_7->setName('Yamaha 7378 34');
        $product_7->setSKU('21876387343');
        $product_7->setDescription('Fast moto');
        $product_7->setCategory($category_7);

        for ($i = 0; $i < 5; $i++) {

            $product1 = new Product();
            $product1->setName('Peugeot 80'.$i.' HDI');
            $product1->setSKU('2323983475314'.$i);
            $product1->setDescription('Big car '.$i);
            $product1->setCategory($category_2);
            $product1->setImage('035066bba210802a265cda0dbc6907df.jpeg');
            $manager->persist($product1);

            $product2 = new Product();
            $product2->setName('iPhone '.$i);
            $product2->setSKU('98092328324'.$i);
            $product2->setDescription('Cool iPhone '.$i);
            $product2->setCategory($category_9);
            $product2->setImage('459e4d8fb6065864084617547d5d263e.jpeg');
            $manager->persist($product2);

            $product3 = new Product();
            $product3->setName('Samsung S'.$i);
            $product3->setSKU('230982124983'.$i);
            $product3->setDescription('Amazing phone '.$i);
            $product3->setCategory($category_10);
            $product3->setImage('4c9bea2248354ed129bbd84b861a832b.jpeg');
            $manager->persist($product3);

            $product5 = new Product();
            $product5->setName('Peugeot 40'.$i.' 2.0');
            $product5->setSKU('232283235314'.$i);
            $product5->setDescription('Big car '.$i);
            $product5->setCategory($category_2);
            $product5->setImage('1326464e73a3ddc717a9509a7ba4c46b.jpeg');
            $manager->persist($product5);

            $product6 = new Product();
            $product6->setName('iPhone C'.$i);
            $product6->setSKU('98012328324'.$i);
            $product6->setDescription('Cool cheap iPhone '.$i);
            $product6->setCategory($category_9);
            $product6->setImage('2292cbfe804bc4083cccd059e269b51d.jpeg');
            $manager->persist($product6);

            $product7 = new Product();
            $product7->setName('Samsung R'.$i);
            $product7->setSKU('230982312983'.$i);
            $product7->setDescription('Amazing new phone '.$i);
            $product7->setCategory($category_10);
            $product7->setImage('6ff35e9c70d8d0b3d29da3a59e980e48.jpeg');
            $manager->persist($product7);

            $user1 = new User();
            $user1->setUsername('Mary '.$i);
            $user1->setEmail('m'.$i.'@mail.ru');
            $user1->setPlainPassword('11111111');
            $user1->setIsActive(true);
            $encoder = $this->container->get('security.password_encoder');
            $password = $encoder->encodePassword($user1, $user1->getPlainPassword());
            $user1->setPassword($password);
            $manager->persist($user1);

            $user2 = new User();
            $user2->setUsername('Vita '.$i);
            $user2->setEmail('v'.$i.'@mail.ru');
            $user2->setPlainPassword('11111111');
            $user2->setIsActive(true);
            $user2->addRoles('ROLE_MANAGER');
            $encoder = $this->container->get('security.password_encoder');
            $password = $encoder->encodePassword($user2, $user2->getPlainPassword());
            $user2->setPassword($password);
            $manager->persist($user2);
        }

        $manager->persist($category_1);
        $manager->persist($category_2);
        $manager->persist($category_3);
        $manager->persist($category_4);
        $manager->persist($category_5);
        $manager->persist($category_6);
        $manager->persist($category_7);
        $manager->persist($category_8);
        $manager->persist($category_9);
        $manager->persist($category_10);
        $manager->persist($user_1);
        $manager->persist($user_2);
        $manager->persist($user_3);
        $manager->persist($product_1);
        $manager->persist($product_2);
        $manager->persist($product_3);
        $manager->persist($product_4);
        $manager->persist($product_5);
        $manager->persist($product_6);
        $manager->persist($product_7);
        $manager->flush();
        // ...
    }
}