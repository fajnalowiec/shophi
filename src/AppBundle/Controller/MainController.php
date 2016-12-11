<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Repository\ProductRepository;
use AppBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Helper\AppLogger;

class MainController extends Controller
{

    private $productsPerPage = 10;
    private $appLogger = null;

    /**
     * some methods would be common for all controllers so probably it is a good idea later to create parent class
     * to put them there and inherit app controllers from it
     */
    private function setAppLogger()
    {
        $this->appLogger = $this->get('app.logger');
    }

    private function getParams()
    {
        $this->productsPerPage = (int) $this->container->getParameter('products_per_page');
    }

    public function indexAction(Request $request)
    {
        try {
            $this->setAppLogger();
            $this->getParams();

            $productModel = $this->getDoctrine()->getManager()->getRepository('AppBundle:Product');
            $query = $productModel->getAllQuery();

            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $query, $request->query->getInt('page', 1), $this->productsPerPage
            );
            return $this->render('main/index.html.twig', array('pagination' => $pagination));
        } catch (\Exception $e) {
            $this->appLogger->logException($e);
            return $this->render('error.html.twig');
        }
    }

}
