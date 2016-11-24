<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CatalogController extends Controller
{
    /**
     * @Route("/catalog", name="catalog")
     * @Template(":catalog:catalog.html.twig")
     */
    public function catalogAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Category')->findAllOrderedByID();
        $categoriesJSON = $this->get('app.ajax_menu_converter')->convertCategoriesToJSON($categories);
        $products = $em->getRepository('AppBundle:Product')->findAllOrderedByID();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $products, /* query NOT categoriesToJSON */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
        return ['answer' => $categoriesJSON, 'pagination' => $pagination];
        // return $this->render(':catalog:catalog.html.twig', ['answer' => $categoriesJSON]);
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
     * @Route("/catalog", name="catalog_ajax")
     */
    public function catalogAjaxAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Category')->findAllOrderedByID();
        $result = $this->get('app.ajax_menu_converter')->convertCategoriesToJSON($categories);
        json_encode(['code'=>'success',
            'result'=>$result,
        ]);
        return $this->render(':catalog:catalog.html.twig', []);
    }


    /**
     * @Route("/catalog/edit", name="catalog_edit")
     */
    public function editCatalogAction()
    {
        return new Response('editCatalog');
    }

    /**
     * @Route("/catalog/edit/add_product", name="add_product")
     */
    public function addProductAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('add_product');
        }

        return $this->render('catalog/edit_product.html.twig', ['form' => $form->createView()]);

    }
}