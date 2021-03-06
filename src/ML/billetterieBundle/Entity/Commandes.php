<?php

namespace ML\billetterieBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Commandes
 *
 * @ORM\Table(name="commandes")
 * @ORM\Entity(repositoryClass="ML\billetterieBundle\Repository\CommandesRepository")
 */
class Commandes
{
    public function __construct() {
        $this->setDateCmd(new \DateTime('NOW'));
        $this->billets = new ArrayCollection();
        $this->setCode(uniqid());
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_cmd", type="date")
     */
    private $dateCmd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_visite", type="date")
     */
    private $dateVisite;

    /**
     * @var float
     *
     * @ORM\Column(name="tarif", type="float")
     */
    private $tarif;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=13, unique=true)
     */
    private $code;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_billets", type="integer")
     */
    private $nbrBillets;

    /**
     * @var boolean
     *
     * @ORM\Column(name="duree", type="boolean")
     */
    private $duree = false;

    /**
     *
     *
     * @ORM\OneToMany(targetEntity="Billets", mappedBy="commandes", cascade={"persist"}))
     */
    private $billets;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateCmd
     *
     * @param \DateTime $dateCmd
     *
     * @return Commandes
     */
    public function setDateCmd($dateCmd)
    {
        $this->dateCmd = $dateCmd;

        return $this;
    }

    /**
     * Get dateCmd
     *
     * @return \DateTime
     */
    public function getDateCmd()
    {
        return $this->dateCmd;
    }

    /**
     * Set dateVisite
     *
     * @param \DateTime $dateVisite
     *
     * @return Commandes
     */
    public function setDateVisite($dateVisite)
    {
        $this->dateVisite = $dateVisite;

        return $this;
    }

    /**
     * Get dateVisite
     *
     * @return \DateTime
     */
    public function getDateVisite()
    {
        return $this->dateVisite;
    }

    /**
     * Set tarif
     *
     * @param float $tarif
     *
     * @return Commandes
     */
    public function setTarif($tarif)
    {
        $this->tarif = $tarif;

        return $this;
    }

    /**
     * Get tarif
     *
     * @return float
     */
    public function getTarif()
    {
        return $this->tarif;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Commandes
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Commandes
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set nbrBillets
     *
     * @param integer $nbrBillets
     *
     * @return Commandes
     */
    public function setNbrBillets($nbrBillets)
    {
        $this->nbrBillets = $nbrBillets;

        return $this;
    }

    /**
     * Get nbrBillets
     *
     * @return int
     */
    public function getNbrBillets()
    {
        return $this->nbrBillets;
    }

    /**
     * Set duree
     *
     * @param boolean $duree
     *
     * @return Commandes
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return boolean
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Add billet
     *
     * @param \ML\billetterieBundle\Entity\Billets $billet
     *
     * @return Commandes
     */
    public function addBillet(\ML\billetterieBundle\Entity\Billets $billet)
    {
        $this->billets[] = $billet;
        $billet->setCommandes($this);

        return $this;
    }

    /**
     * Remove billet
     *
     * @param \ML\billetterieBundle\Entity\Billets $billet
     */
    public function removeBillet(\ML\billetterieBundle\Entity\Billets $billet)
    {
        $this->billets->removeElement($billet);
    }

    /**
     * Get billets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBillets()
    {
        return $this->billets;
    }
}
