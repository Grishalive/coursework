<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CatalogController extends Controller
{
    /**
     * @Route("/catalog", name="catalog")
     */
    public function catalogAction(Request $request)
    {
        return new Response('Catalog');
    }

    /**
     * @Route("/catalog/edit", name="edit_catalog")
     */
    public function editCatalogAction(Request $request)
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