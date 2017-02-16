<?php

namespace RennesJeux\SondageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use RennesJeux\SondageBundle\Entity\Session;

class SessionController extends Controller
{
    /**
     * Liste les sessions de jeux dont la date est >= a la date du jour
     */
    public function listeAction($affichage)
    {
        $user = $this->getUser();
        if (null === $user)
        {
            return $this->redirectToRoute('login');
        }
                
        return $this->render('RennesJeuxSondageBundle:Sessions:liste.html.twig', array('affichage' => $affichage));
    }

    /**
    *	Liste les sessions proposées n'ayant pas atteint le nombre requis de participant pour devenir validées
    */
    public function proposeesAction($apercu)
    {
        $user = $this->getUser();
        if (null === $user)
        {
            return $this->redirectToRoute('login');
        }

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('RennesJeuxSondageBundle:Session');

        $requete = $repository->sessionsProposees();
        $sessionsProposees = $repository->Execution($requete);

        return $this->render('RennesJeuxSondageBundle:Sessions:sessions.html.twig', array('sessions' => $sessionsProposees, 'type' => 'p', 'apercu' => $apercu));

    }

    /**
    *	Liste les sessions ayant atteint le nombre requis de participant
    */
    public function valideesAction($apercu)
    {
        $user = $this->getUser();
        if (null === $user)
        {
            return $this->redirectToRoute('login');
        }
        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('RennesJeuxSondageBundle:Session');

        $requete = $repository->sessionsValidees();
        $sessionsValidees = $repository->Execution($requete);

        return $this->render('RennesJeuxSondageBundle:Sessions:sessions.html.twig', array('sessions' => $sessionsValidees, 'type' => 'v', 'apercu' => $apercu));
    }
    
    /**
     * Inscription a une session
     * @param int $id id de la session
     * @return type
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
     * Desinscription a une session
     * @param int $id
     * @return type
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
            if (strtoupper($user->getUsername()) == strtoupper($joueur->getUsername()))
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