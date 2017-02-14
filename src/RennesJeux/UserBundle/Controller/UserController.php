<?php

namespace RennesJeux\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController extends Controller
{
    /**
     * @Route("/inscription/{id}", requirements={"id" = "\d+"}, name="user.inscription")
     */
    public function inscriptionAction($id)
    {
        $user = $this->getUser();
        if (null === $user)
        {
            return $this->redirectToRoute('login');
        }
        else 
        {
            $user_name = $user->getUsername();
        }
        
        $em = $this->getDoctrine()->getManager();
        $sessionJeu = $em->getRepository('RennesJeuxSondageBundle:Session')->findSession($id);

        // s'il reste de la place, on s'inscrit
        if ($sessionJeu->getNbParticipants() < $sessionJeu->getJeu()->getNbparticipantmax())
        {
            $joueur = $em->getRepository('RennesJeuxUserBundle:User')->findOneByUsername($user_name);
            $sessionJeu->addJoueur($joueur);
            $sessionJeu->increaseParticipants();
            $em->flush();
        }

        return $this->redirectToRoute('rennes_jeux_sondage_liste');

    }

    /**
     * @Route("/desinscription/{id}", requirements={"id" = "\d+"}, name"user.desinscription")
     */
    public function desinscriptionAction($id)
    {
        $user = $this->getUser();
        if (null === $user)
        {
            return $this->redirectToRoute('login');
        }

        $em = $this->getDoctrine()->getManager();
        // on recupere la session est les joueurs associes
        $sessionJoueur = $em->getRepository('RennesJeuxSondageBundle:Session')->find($id);

        // on verifie que le user est bien inscrit a la session
        foreach ($sessionJoueur->getJoueurs() as $joueur) 
        {
            if (strtoupper($user_name) == strtoupper($joueur->getNom()))
            {
                // on reduit le nombre de participant
                $sessionJoueur->removeJoueur($joueur);
                $sessionJoueur->decreaseParticipants();
                $em->flush();
            }
        }

        return $this->redirectToRoute('rennes_jeux_sondage_liste');
    }

}
