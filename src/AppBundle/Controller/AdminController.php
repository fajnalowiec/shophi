<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ProductForm;
use AppBundle\Entity\Product;
use AppBundle\Repository\ProductRepository;
use AppBundle\Helper\FlashMessage;

class AdminController extends Controller
{

    public function indexAction(Request $request)
    {
        return $this->render('admin/index.html.twig', array());
    }

    public function addItemAction(Request $request)
    {
        try {
            $flashMessage = $this->get('app.flash.message');
            $appLogger = $this->get('app.logger');
            $product = new Product();

            $form = $this->createForm(ProductForm::class, $product, array('container' => $this->container));
            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                if ($form->isValid()) {
                    $product = $form->getData();

                    $productModel = $this->getDoctrine()->getManager()->getRepository('AppBundle:Product');
                    $productModel->insert($product);

                    $this->sendEmailProductIsAdded($product);

                    $flashMessage->add('Product has been added.');
                    $appLogger->logMessage('Product added:' . var_export($product, true));

                    return $this->redirectToRoute('admin_main');
                } else {
                    foreach ($form->getErrors(true) as $error) {
                        $flashMessage->add($error->getMessage(), FlashMessage::ERROR_STRING);
                    }
                }
            }
            return $this->render('admin/add_item.html.twig', array('form' => $form->createView(),));
        } catch (\Exception $e) {
            $appLogger->logException($e);
            return $this->render('error.html.twig');
        }
    }

    private function sendEmailProductIsAdded($product)
    {
        $appMailer = $this->get('app.mailer');
        $message = $appMailer->createMessage(
            'New product added', 'Emails/new_product.html.twig', array(
            'user_name' => $this->get('security.token_storage')->getToken()->getUser()->getUsername(),
            'product_id' => $product->getId(),
            'product_name' => $product->getName(),
            'product_price' => $product->getPrice(),
            'product_description' => $product->getDescription()
        ));
        $appMailer->sendMessage($message);
    }

}
