<?php

namespace RennesJeux\SondageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Jeux
 *
 * @ORM\Table(name="jeux")
 * @ORM\Entity(repositoryClass="RennesJeux\SondageBundle\Repository\JeuxRepository")
 */
class Jeux
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="hote", type="string", length=255)
     */
    private $hote;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="string", length=255)
     */
    private $lieu;

    /**
     * @var int
     *
     * @ORM\Column(name="nbparticipantmin", type="integer", nullable=true)
     */
    private $nbparticipantmin;

    /**
     * @var int
     *
     * @ORM\Column(name="nbparticipantmax", type="integer")
     */
    private $nbparticipantmax;

    /**
     * @ORM\OneToMany(targetEntity="RennesJeux\SondageBundle\Entity\Session", mappedBy="jeu")
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid()
    */
    private $sessions;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sessions = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Jeux
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set hote
     *
     * @param string $hote
     *
     * @return Jeux
     */
    public function setHote($hote)
    {
        $this->hote = $hote;

        return $this;
    }

    /**
     * Get hote
     *
     * @return string
     */
    public function getHote()
    {
        return $this->hote;
    }

    /**
     * Set lieu
     *
     * @param string $lieu
     *
     * @return Jeux
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set nbparticipantmin
     *
     * @param integer $nbparticipantmin
     *
     * @return Jeux
     */
    public function setNbparticipantmin($nbparticipantmin)
    {
        $this->nbparticipantmin = $nbparticipantmin;

        return $this;
    }

    /**
     * Get nbparticipantmin
     *
     * @return integer
     */
    public function getNbparticipantmin()
    {
        return $this->nbparticipantmin;
    }

    /**
     * Set nbparticipantmax
     *
     * @param integer $nbparticipantmax
     *
     * @return Jeux
     */
    public function setNbparticipantmax($nbparticipantmax)
    {
        $this->nbparticipantmax = $nbparticipantmax;

        return $this;
    }

    /**
     * Get nbparticipantmax
     *
     * @return integer
     */
    public function getNbparticipantmax()
    {
        return $this->nbparticipantmax;
    }

    /**
     * Add session
     *
     * @param \RennesJeux\SondageBundle\Entity\Session $session
     *
     * @return Jeux
     */
    public function addSession(\RennesJeux\SondageBundle\Entity\Session $session)
    {
        $session->setJeu($this);
        $this->sessions[] = $session;

        return $this;
    }

    /**
     * Remove session
     *
     * @param \RennesJeux\SondageBundle\Entity\Session $session
     */
    public function removeSession(\RennesJeux\SondageBundle\Entity\Session $session)
    {
        $this->sessions->removeElement($session);
    }

    /**
     * Get sessions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSessions()
    {
        return $this->sessions;
    }
}
