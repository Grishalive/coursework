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
     * @Template(":edit_catalog:catalog.html.twig")
     */
    public function catalogAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Category')->findAllOrderedByID();
        $result = $this->get('app.ajax_menu_converter')->convertCategoriesToJSON($categories);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $categories, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
        return ['answer' => $result, 'pagination' => $pagination];
        // return $this->render(':edit_catalog:catalog.html.twig', ['answer' => $result]);
    }

    /**
     * @Route("/catalog/p", name="catalog_paginate")
     *
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Category')->findAllOrderedByID();



        // parameters to template
        return $this->render(':edit_catalog:test.html.twig', array());
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
        return $this->render(':edit_catalog:catalog.html.twig', []);
    }


    /**
     * @Route("/catalog/edit", name="edit_catalog")
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

        return $this->render('edit_catalog/edit_product.html.twig', ['form' => $form->createView()]);

    }
}