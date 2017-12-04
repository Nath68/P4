<?php

namespace ML\billetterieBundle\Controller;

use ML\billetterieBundle\Entity\Billets;
use ML\billetterieBundle\Form\BilletsType;
use ML\billetterieBundle\Form\CommandesType;
use ML\billetterieBundle\Repository\CommandesRepository;
use ML\billetterieBundle\Services\Calculator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ML\billetterieBundle\Entity\Commandes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Valid;
use ML\billetterieBundle\Repository;

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

            $maxBillets = $this->getDoctrine()->getRepository("MLbilletterieBundle:Commandes")
                ->checkBillets($commande->getDateVisite());
            if ($maxBillets == true) {
                $this->addFlash("notice","Nombre maximum de billets atteint pour le jour sélectionné !");
                return $this->render('MLbilletterieBundle:Billetterie:index.html.twig', array('formC'=>$formC->createView()));
            }

            $this->get('app.calculator')->calculTarif($commande);
            $session = $request->getSession();
            $session->set('commande', $commande);

        }

        if ($formC->isSubmitted() && $formC->isValid()) {
            return $this->render('MLbilletterieBundle:Billetterie:resume.html.twig', array('commande'=>$commande));
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

        try {
            \Stripe\Charge::create(array(
                "amount" => $tarif, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Commande n° ".$commande->getCode()
            ));
            $this->addFlash("notice","Paiement validé !");

            //FLUSH DB !
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            return $this->redirectToRoute("mail", array('code'=>$commande->getCode()));
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("error","Paiement refusé !");
            return $this->redirectToRoute("order_prepare");
        }
    }

    public function mailAction($code)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT c FROM MLbilletterieBundle:Commandes c WHERE c.code = :code');
        $query->setParameter('code', $code);
        $commande = $query->getSingleResult();

        $mail = $commande->getMail();

        $message = \Swift_Message::newInstance()
            ->setSubject('Confirmation de commande n°'.$commande->getCode())
            ->setFrom(array('assistance-billetterie@louvre.fr' => 'Service client'))
            ->setTo($mail)
            ->setContentType("text/html")
        ;
        $img = $message->embed(\Swift_Image::fromPath('public/img/logo-louvre.jpg'));
        $message->setBody($this->renderView('MLbilletterieBundle:Billetterie:mail.html.twig', array('commande'=>$commande, 'img'=>$img)));

        $this->get('mailer')->send($message);



        return $this->redirectToRoute("mlbilletterie_homepage");
    }
}