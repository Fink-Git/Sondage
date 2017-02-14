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

        $requete = $repository->sessionsProposees($apercu);
        $sessionsProposees = $repository->Execution($requete);

        return $this->render('RennesJeuxSondageBundle:Sessions:sessions.html.twig', array('sessions' => $sessionsProposees, 'type' => 'p'));

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

        $requete = $repository->sessionsValidees($apercu);
        $sessionsValidees = $repository->Execution($requete);

        return $this->render('RennesJeuxSondageBundle:Sessions:sessions.html.twig', array('sessions' => $sessionsValidees, 'type' => 'v'));
    }
}