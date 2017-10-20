<?php

namespace ML\billetterieBundle\Controller;

use ML\billetterieBundle\Entity\Billets;
use ML\billetterieBundle\Form\BilletsType;
use ML\billetterieBundle\Form\CommandesType;
use ML\billetterieBundle\Services\Calculator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ML\billetterieBundle\Entity\Commandes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Valid;

class BilletterieController extends Controller
{
    public function indexAction(Request $request)
    {
        $commande = new Commandes();
        $formC = $this->createForm(
            CommandesType::class, $commande
        );

        if ($formC -> handleRequest($request) && $formC->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->get('app.calculator')->calculTarif($commande);
            $em->persist($commande);
            $session = $request->getSession();
            $session->set('commande', $commande);
        }

        if ($request->isMethod('POST')) {
            if ($formC->isValid()) {
                //$em->flush();
                return $this->render('MLbilletterieBundle:Billetterie:resume.html.twig', array('commande'=>$commande));
            }
        }


        return $this->render('MLbilletterieBundle:Billetterie:index.html.twig',
            array('formC'=>$formC->createView()));
    }

    public function prepareAction()
    {
        return $this->render('MLbilletterieBundle:Billetterie:prepare.html.twig');
    }

    public function checkoutAction(Request $request)
    {
        \Stripe\Stripe::setApiKey("sk_test_8QQmpwx1lhq1CggvKz28zqDz");

        // Get the credit card details submitted by the form
        $token = $request->request->get('stripeToken');
        $session = $request->getSession();
        $commande = $session->get('commande');
        $tarif = $commande->getTarif();
        $tarif *= 100;

        // Create a charge: this will charge the user's card
        try {
            \Stripe\Charge::create(array(
                "amount" => $tarif, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Commande n° ".$commande->getCode()
            ));
            $this->addFlash("success","Paiement validé !");
            return $this->redirectToRoute("mail");
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("error","Paiement refusé !");
            return $this->redirectToRoute("order_prepare");
            // The card has been declined
        }
    }

    public function mailAction(Request $request)
    {
        $session = $request->getSession();
        $commande = $session->get('commande');
        $mail = $commande->getMail();

        $message = \Swift_Message::newInstance()
            ->setSubject('Confirmation de commande')
            ->setFrom(array('assistance-billetterie@louvre.fr' => 'Service client'))
            ->setTo($mail)
            ->setBody('Contenu du mail', 'text/plain', 'UTF-8')
        ;

        $this->get('mailer')->send($message);



        return $this->redirectToRoute("mlbilletterie_homepage");
    }
}