<?php
/**
 * Created by PhpStorm.
 * User: nduvi
 * Date: 03/11/2017
 * Time: 09:39
 */

namespace ML\billetterieBundle\Tests\Repository;

use ML\billetterieBundle\Entity\Commandes;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testTrueMaxBillets() {
        $maxBillets = $this->em
            ->getRepository(Commandes::class)
            ->checkBillets(new \DateTime('2017/09/23'))
        ;
        $this->assertTrue($maxBillets);
    }

    public function testFalseMaxBillets() {
        $maxBillets = $this->em
            ->getRepository(Commandes::class)
            ->checkBillets(new \DateTime('2017/11/10'))
        ;
        $this->assertFalse($maxBillets);
    }
}