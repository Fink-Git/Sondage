<?php

namespace RennesJeux\SondageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use RennesJeux\SondageBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Description of UserController
 *
 * @author SLA11167
 */
class UserController extends Controller
{
    /**
    * Login et inscription l'appli
    */
    public function loginAction(Request $request)
    {
        $user = new User();
        
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $user);
        
        $formBuilder
                ->add('nom', TextType::class, array('label' => 'pseudo'))
                ->add('login', SubmitType::class);
        
        $form = $formBuilder->getForm();
            
        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                // verification (simple) de l'existence du user
                $userEnBase = $em->getRepository('RennesJeuxSondageBundle:User')->findOneByNom($user->getNom());
                
                $session = $request->getSession();
                $session->set('user_name',$user->getNom());
                if (!$userEnBase)
                {
                    // si le user n'existe pas, on l'enregistre en base
                    $em->persist($user);
                    $em->flush();
                }
                
                return $this->redirectToRoute('rennes_jeux_sondage_liste');
            }
        }
        
        return $this->render('RennesJeuxSondageBundle:User:login.html.twig', array('form' => $form->createView(),));
    }

    /**
    * Deconnexion
    */
    public function disconnectAction(Request $request)
    {
        $session = $request->getSession();
        $session->set('user_name', null);

        return $this->redirectToRoute('rennes_jeux_sondage_homepage');
    }

    /**
    * Inscription a une session de jeu
    */
    public function inscriptionAction(Request $request, $id)
    {
        $user_name = $request->getSession()->get('user_name');

        $em = $this->getDoctrine()->getManager();
        $sessionJeu = $em->getRepository('RennesJeuxSondageBundle:Session')->findSession($id);

        // s'il reste de la place, on s'inscrit
        if ($sessionJeu->getNbParticipants() < $sessionJeu->getJeu()->getNbparticipantmax())
        {
            $joueur = $em->getRepository('RennesJeuxSondageBundle:User')->findOneByNom($user_name);
            $sessionJeu->addJoueur($joueur);
            $sessionJeu->increaseParticipants();
            $em->flush();
        }

        return $this->redirectToRoute('rennes_jeux_sondage_liste');

    }

    /**
    * Desinscription a une session de jeu
    */
    public function desinscriptionAction(Request $request, $id)
    {
        
        $user_name = $request->getSession()->get('user_name');

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
