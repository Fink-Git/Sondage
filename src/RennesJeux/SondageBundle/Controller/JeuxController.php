<?php

namespace RennesJeux\SondageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use RennesJeux\SondageBundle\Form\JeuxType;
use RennesJeux\SondageBundle\Entity\Jeux;
//use RennesJeux\SondageBundle\Entity\Session;

/**
 * Description of JeuxController
 *
 * @author SLA11167
 */
class JeuxController extends Controller
{
    /**
     * Ajoute une proposition de jeux et ses sessions
     */
    public function addAction(Request $request)
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

        $jeu = new Jeux();
        $em = $this->getDoctrine()->getManager();

        $joueur = $em->getRepository('RennesJeuxUserBundle:User')->findOneByUsername($user_name);
        $jeu->setHote($joueur->getUsername());

        $form   = $this->get('form.factory')->create(JeuxType::class, $jeu);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($jeu);

            foreach ($jeu->getSessions() as $session) {
                $session->addJoueur($joueur);
                $session->increaseParticipants();
                $em->persist($session);
            }
            $em->flush();

            //$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            return $this->redirectToRoute('rennes_jeux_sondage_liste');
        }

        return $this->render('RennesJeuxSondageBundle:Jeux:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Modifie une proposition de jeux
     */
    public function editAction()
    {

    }
    
}
