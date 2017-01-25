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
                $userEnBase = $em->getRepository('RennesJeuxSondageBundle:User')->findOneByNom(strtoupper($user->getNom()));
                
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

    public function disconnectAction(Request $request)
    {
        $session = $request->getSession();
        $session->set('user_name', null);

        return $this->redirectToRoute('rennes_jeux_sondage_homepage');
    }

    public function inscriptionAction($session)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('RennesJeuxSondageBundle:Session')->find($session.id)->increaseParticipants();
    }

    public function descinscriptionAction($session)
    {

    }
}
