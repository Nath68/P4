<?php
/**
 * Created by PhpStorm.
 * User: nduvi
 * Date: 23/09/2017
 * Time: 10:26
 */

namespace ML\billetterieBundle\Services;

class Calculator
{
    public function calculTarif($commande){
        $i = 0;
        $total = 0;
        $dateVisite = strtotime($commande->getDateVisite()->format('dd-mm-yyyy'));

        foreach ($commande->getBillets() as $billet) {
            $dateNaissance = strtotime($billet->getDateNaissance()->format('dd-mm-yyyy'));
            $age = $dateVisite - $dateNaissance;

            if ($billet->getTarifReduit()) {
                $tarif = 10;
            }
            else {
                switch ($age) {
                    case $age < 4 :
                        $tarif = 0;
                        break;

                    case $age >= 4 && $age < 12 :
                        $tarif = 8;
                        break;

                    case $age >= 60 :
                        $tarif = 12;
                        break;
                    default:
                        $tarif = 16;
                        break;
                }
            }

            $total += $tarif;
            $i++;
        }

        if ($commande->getDuree()) {
            $total *= 0.65;
        }

        $commande->setTarif($total);
        $commande->setNbrBillets($i);
    }
}