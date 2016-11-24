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

        $user_1 = new User();
        $user_1->setUsername('grisha');
        $user_1->setEmail('g@mail.ru');
        $user_1->setPlainPassword('1111');
        $user_1->setIsActive(true);
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user_1, $user_1->getPlainPassword());
        $user_1->setPassword($password);

        $user_2 = new User();
        $user_2->setUsername('vita');
        $user_2->setEmail('v@mail.ru');
        $user_2->setPlainPassword('1111');
        $user_2->setIsActive(true);
        $user_2->addRoles('ROLE_MANAGER');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user_2, $user_2->getPlainPassword());
        $user_2->setPassword($password);

        $user_3 = new User();
        $user_3->setUsername('masha');
        $user_3->setEmail('m@mail.ru');
        $user_3->setPlainPassword('1111');
        $user_3->setIsActive(true);
        $user_3->addRoles('ROLE_ADMIN');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user_3, $user_3->getPlainPassword());
        $user_3->setPassword($password);

        $product_1 = new Product();
        $product_1->setId(0);
        $product_1->setName('Yamaha 2014 MX245');
        $product_1->setSKU('2345234');
        $product_1->setDescription('Хороший мот');
        $product_1->setCategory($category_7);


        $manager->persist($category_1);
        $manager->persist($category_2);
        $manager->persist($category_3);
        $manager->persist($category_4);
        $manager->persist($category_5);
        $manager->persist($category_6);
        $manager->persist($category_7);
        $manager->persist($user_1);
        $manager->persist($user_2);
        $manager->persist($user_3);
        $manager->persist($product_1);
        $manager->flush();
        // ...
    }
}