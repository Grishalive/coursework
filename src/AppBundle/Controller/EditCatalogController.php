<?php


namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class EditCatalogController extends Controller
{
    /**
     * @Route("/sssssss", name="adminasd")
     */
    public function editCatalogAction()
    {
        return new Response('editCatalog');
    }
}