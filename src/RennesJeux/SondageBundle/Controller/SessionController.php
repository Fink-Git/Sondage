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
    public function listeAction(Request $request)
    {
        $user_name = $request->getSession()->get('user_name');
        if (!$user_name)
        {
            return $this->redirectToRoute('rennes_jeux_sondage_login');
        }
        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('RennesJeuxSondageBundle:Session');

        $requete = $repository->sessionsProposees(true);
        $sessionsProposees = $repository->Execution($requete);

        $requete = $repository->sessionsValidees(true);
        $sessionsValidees = $repository->Execution($requete);

        return $this->render('RennesJeuxSondageBundle:Sessions:liste.html.twig', array('user_name' => $user_name,'sessionsProposees' => $sessionsProposees,'sessionsValidees' => $sessionsValidees));
    }

    /**
    *	Liste les sessions proposées n'ayant pas atteint le nombre requis de participant pour devenir validées
    */
    public function proposeesAction(Request $request)
    {
    	$user_name = $request->getSession()->get('user_name');
        if (!$user_name)
        {
            return $this->redirectToRoute('rennes_jeux_sondage_login');
        }

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('RennesJeuxSondageBundle:Session');

        $requete = $repository->sessionsProposees(false);
        $sessionsProposees = $repository->Execution($requete);

        return $this->render('RennesJeuxSondageBundle:Sessions:sessions.html.twig', array('sessions' => $sessionsProposees, 'type' => 'p'));

    }

    /**
    *	Liste les sessions ayant atteint le nombre requis de participant
    */
    public function valideesAction(Request $request)
    {
    	$user_name = $request->getSession()->get('user_name');
        if (!$user_name)
        {
            return $this->redirectToRoute('rennes_jeux_sondage_login');
        }

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('RennesJeuxSondageBundle:Session');

        $requete = $repository->sessionsValidees(false);
        $sessionsValidees = $repository->Execution($requete);

        return $this->render('RennesJeuxSondageBundle:Sessions:sessions.html.twig', array('sessions' => $sessionsValidees, 'type' => 'v'));
    }
}