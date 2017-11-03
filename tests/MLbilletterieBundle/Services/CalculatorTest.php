<?php
/**
 * Created by PhpStorm.
 * User: nduvi
 * Date: 30/10/2017
 * Time: 14:41
 */
namespace ML\billetterieBundle\Tests\Services;

use ML\billetterieBundle\Services\Calculator;
use PHPUnit\Framework\TestCase;
use ML\billetterieBundle\Entity\Commandes;
use ML\billetterieBundle\Entity\Billets;

class CalculatorTest extends TestCase
{
    public function testcalculTarif() {
        $commande = new Commandes();
        $commande->setDateVisite(new \DateTime('2017/02/11'));
        $commande->setDuree(false);
        $billet = new Billets();
        $billet->setDateNaissance(new \DateTime('1993/09/16'));
        $billet->setTarifReduit(false);
        $commande->addBillet($billet);

        $calculator = new Calculator();
        $calculator->calculTarif($commande);
        $this->assertEquals(8, $commande->getTarif());
        $this->assertEquals(1, $commande->getNbrBillets());
}
}