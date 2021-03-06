<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use AppBundle\Form\CategoryType;
use AppBundle\Form\ProductType;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class CatalogController extends Controller
{
    /**
     * @Route("/catalog", name="catalog")
     * @Template(":catalog:catalog.html.twig")
     */
    public function catalogAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->get('category_id')){
            $this->get('session')->set('category_id', $request->get('category_id'));
            $category = $em->getRepository('AppBundle:Category')->find($request->get('category_id'));
            $products = $category->getProducts();
            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $products, /* query NOT categoriesToJSON */
                $request->query->getInt('page', 1)/*page number*/,
                4/*limit per page*/
            );
            return $this->render(":catalog:pagination.html.twig",['pagination' => $pagination, 'category_id' => $request->get('category_id')]);
        } else {
            if ($this->get('session')->get('category_id')) {
                $category = $em->getRepository('AppBundle:Category')->find($this->get('session')->get('category_id'));
                if ($category) {
                    $products = $category->getProducts();
                } else {
                    $products = $em->getRepository('AppBundle:Product')->findAllOrderedByID();
                }
            } else {
                $products = $em->getRepository('AppBundle:Product')->findAllOrderedByID();
            }
        }
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $products, /* query NOT categoriesToJSON */
            $request->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/
        );
        $categories = $em->getRepository('AppBundle:Category')->findAllOrderedByID();
        $categoriesJSON = $this->get('app.ajax_menu_converter')->convertCategoriesToJSON($categories, $this->get('session')->get('category_id'));
        return ['answer' => $categoriesJSON, 'pagination' => $pagination, 'category_id' => $request->get('category_id')];
    }


    /**
     *
     * @Route("/catalog/product/{id}", name="show_product", requirements={"id": "\d+"})
     * @Template(":catalog:show_product.html.twig")
     * @param $id
     * @return array
     */
    public function showProductAction($id)
    {
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($id);
        return ['product' => $product];
    }


    /**
     * @Route("/catalog/edit", name="catalog_edit")
     * @Template(":catalog:edit_catalog.html.twig")
     */
    public function editCatalogAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        switch ($request->query->get('action')) {
            case 'move_category':
                $category_id = $request->query->get('id');
                $old_parent = $request->query->get('old_parent');
                $new_parent = $request->query->get('new_parent');
                $em->getRepository('AppBundle:Category')->moveCategory($category_id, $old_parent, $new_parent);
                break;
            case 'move_product':
                $product_id = $request->query->get('id');
                $old_parent = $request->query->get('old_parent');
                $new_parent = $request->query->get('new_parent');
                $em->getRepository('AppBundle:Product')->moveProduct($product_id, $old_parent, $new_parent);
                break;
        }
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('AppBundle:Product')->findAllOrderedByID();
        $categories = $em->getRepository('AppBundle:Category')->findAllOrderedByID();
        $result = $this->get('app.ajax_menu_converter')
            ->convertCategoriesProductsToJSON($categories, $products);
        return ['tree' => $result];
    }

    /**
     * @Route("/catalog/edit/add/product", name="add_product")
     */
    public function addProductAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!preg_match('/^[1-9][0-9]*$/', $form->getData()->getSKU())) {
                $form->get('SKU')->addError(new FormError('SKU must be numeric!'));
                return $this->render('catalog/edit_product.html.twig', ['form' => $form->createView(),
                    'title' => 'Add Product',
                    'button_text' => 'Add',
                ]);
            }
            // $file stores the uploaded PDF file
            $file = $product->getImage();
            if ($file) {
                // Generate a unique name for the file before saving it
                $fileName = md5(uniqid()).'.'.$file->guessExtension();

                // Move the file to the directory where brochures are stored
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );

                // Update the 'brochure' property to store the PDF file name
                // instead of its contents
                $product->setImage($fileName);

            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('catalog_edit');
        }

        return $this->render('catalog/edit_product.html.twig', ['form' => $form->createView(),
            'title' => 'Add Product',
            'button_text' => 'Add'
        ]);
    }

    /**
     * @Route("/catalog/edit/add/category", name="add_category")
     */
    public function addCategoryAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('catalog_edit');
        }

        return $this->render(':catalog:edit_category.html.twig', ['form' => $form->createView(),
            'title' => 'Add Category',
            'button_text' => 'Add',
        ]);
    }

    /**
     * @Route("/catalog/edit/product/{id}", requirements={"id": "\d+"}, name="edit_product")
     */
    public function editProductAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:Product')->findOneBy(['sku' => $id]);
        $image_path = $product->getImage();
        if($image_path) {
            $product->setImage(
                new File($this->getParameter('images_directory') . '/' . $product->getImage())
            );
        }
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!preg_match('/^[1-9][0-9]*$/', $form->getData()->getSKU())) {
                $form->get('SKU')->addError(new FormError('SKU must be numeric!'));
                return $this->render('catalog/edit_product.html.twig', ['form' => $form->createView(),
                    'title' => 'Edit Product',
                    'button_text' => 'Edit',
                    'image_path' => $image_path,
                ]);
            }
            // $file stores the uploaded PDF file
            $file = $product->getImage();
            if ($file) {
                // Generate a unique name for the file before saving it
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                // Move the file to the directory where brochures are stored
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );

                // Update the 'brochure' property to store the PDF file name
                // instead of its contents
                $product->setImage($fileName);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('catalog_edit');
        }

        return $this->render('catalog/edit_product.html.twig', ['form' => $form->createView(),
            'title' => 'Edit Product',
            'button_text' => 'Edit',
            'image_path' => $image_path,
        ]);
    }

    /**
     * @Route("/catalog/edit/category/{id}", requirements={"id": "\d+"}, name="edit_category")
     */
    public function editCategoryAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AppBundle:Category')->find($id);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('catalog_edit');
        }
        return $this->render('catalog/edit_category.html.twig', ['form' => $form->createView(),
            'title' => 'Edit Category',
            'button_text' => 'Edit'
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAllOrderedByID();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $users, /* query NOT categoriesToJSON */
            $request->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/
        );
        return $this->render(":catalog:admin.html.twig",['pagination' => $pagination,]);

    }
}