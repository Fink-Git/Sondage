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
    public function listeAction(Request $request, $affichage)
    {
        $user_name = $request->getSession()->get('user_name');
        if (!$user_name)
        {
            return $this->redirectToRoute('rennes_jeux_sondage_login');
        }
        
        return $this->render('RennesJeuxSondageBundle:Sessions:liste.html.twig', array('affichage' => $affichage));
    }

    /**
    *	Liste les sessions proposées n'ayant pas atteint le nombre requis de participant pour devenir validées
    */
    public function proposeesAction(Request $request, $apercu)
    {
        $user_name = $request->getSession()->get('user_name');
        if (!$user_name)
        {
            return $this->redirectToRoute('rennes_jeux_sondage_login');
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
    public function valideesAction(Request $request, $apercu)
    {
        $user_name = $request->getSession()->get('user_name');
        if (!$user_name)
        {
            return $this->redirectToRoute('rennes_jeux_sondage_login');
        }

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('RennesJeuxSondageBundle:Session');

        $requete = $repository->sessionsValidees($apercu);
        $sessionsValidees = $repository->Execution($requete);

        return $this->render('RennesJeuxSondageBundle:Sessions:sessions.html.twig', array('sessions' => $sessionsValidees, 'type' => 'v'));
    }
}