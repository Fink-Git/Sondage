<?php

namespace RennesJeux\SondageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Session
 *
 * @ORM\Table(name="session")
 * @ORM\Entity(repositoryClass="RennesJeux\SondageBundle\Repository\SessionRepository")
 */
class Session
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetimetz")
     * @Assert\DateTime()
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="RennesJeux\SondageBundle\Entity\Jeux", inversedBy="sessions")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $jeu;
    
    /**
     * @ORM\ManyToMany(targetEntity="RennesJeux\UserBundle\Entity\User")
     */
    private $joueurs;

    /**
    * @ORM\Column(name="nb_participants", type="integer")
    */
    private $nbParticipants;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        //$this->setNbParticipants(0);
        $this->joueurs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Session
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @Assert\IsTrue(message = "La date doit au moins egale a la date du jour")
     *
    public function isDateValid()
    {
        return $this->date >= new \DateTime();
    }*/
    
    /**
     * Set nbParticipants
     *
     * @param integer $nbParticipants
     *
     * @return Session
     */
    public function setNbParticipants($nbParticipants)
    {
        $this->nbParticipants = $nbParticipants;

        return $this;
    }

    /**
     * Get nbParticipants
     *
     * @return integer
     */
    public function getNbParticipants()
    {
        return $this->nbParticipants;
    }

    /**
     * Set jeu
     *
     * @param \RennesJeux\SondageBundle\Entity\Jeux $jeu
     *
     * @return Session
     */
    public function setJeu(\RennesJeux\SondageBundle\Entity\Jeux $jeu)
    {
        $this->jeu = $jeu;

        return $this;
    }

    /**
     * Get jeu
     *
     * @return \RennesJeux\SondageBundle\Entity\Jeux
     */
    public function getJeu()
    {
        return $this->jeu;
    }

    /**
     * Add joueur
     *
     * @param \RennesJeux\UserBundle\Entity\User $joueur
     *
     * @return Session
     */
    public function addJoueur(\RennesJeux\UserBundle\Entity\User $joueur)
    {
        $this->joueurs[] = $joueur;

        return $this;
    }

    /**
     * Remove joueur
     *
     * @param \RennesJeux\UserBundle\Entity\User $joueur
     */
    public function removeJoueur(\RennesJeux\UserBundle\Entity\User $joueur)
    {
        $this->joueurs->removeElement($joueur);
    }

    /**
     * Get joueurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJoueurs()
    {
        return $this->joueurs;
    }

    public function increaseParticipants()
    {
        $this->nbParticipants++;
    }
    public function decreaseParticipants()
    {
        $this->nbParticipants--;
    }
    
}
