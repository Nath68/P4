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
        $commande->setDateVisite('02/11/2017')->setDuree(false);
        $billet = new Billets();
        $billet->setDateNaissance('16/09/1993')
        ->setTarifReduit(false);
        $commande->addBillet($billet);

        $result = Calculator::class->calculTarif($commande);
        $this->assertSame(8, $result);
    }
}