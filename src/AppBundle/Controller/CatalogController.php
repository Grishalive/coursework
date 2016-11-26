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
//        if ($request->isXmlHttpRequest()) {
//            $category = $em->getRepository('AppBundle:Category')->find($request->get('id'));
//            $products = $category->getProducts();
//            $paginator  = $this->get('knp_paginator');
//            $pagination = $paginator->paginate(
//                $products, /* query NOT categoriesToJSON */
//                $request->query->getInt('page', 1)/*page number*/,
//                1/*limit per page*/
//            );
//            return $this->render(":catalog:pagination.html.twig", ['pagination' => $pagination]);
//        }
        if ($request->get('category_id')){
            $this->get('session')->set('category_id', $request->get('category_id'));
            $category = $em->getRepository('AppBundle:Category')->find($request->get('category_id'));
            $products = $category->getProducts();
            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $products, /* query NOT categoriesToJSON */
                $request->query->getInt('page', 1)/*page number*/,
                1/*limit per page*/
            );
            return $this->render(":catalog:pagination.html.twig",['pagination' => $pagination, 'category_id' => $request->get('category_id')]);
        } else {
            if ($this->get('session')->get('category_id')) {
                $category = $em->getRepository('AppBundle:Category')->find($this->get('session')->get('category_id'));
                $products = $category->getProducts();
            } else {
                $products = $em->getRepository('AppBundle:Product')->findAllOrderedByID();
            }
        }
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $products, /* query NOT categoriesToJSON */
            $request->query->getInt('page', 1)/*page number*/,
            1/*limit per page*/
        );
        $categories = $em->getRepository('AppBundle:Category')->findAllOrderedByID();
        $categoriesJSON = $this->get('app.ajax_menu_converter')->convertCategoriesToJSON($categories);
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