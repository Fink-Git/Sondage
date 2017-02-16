<?php

namespace RennesJeux\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;

/**
 * Description of SecurityController
 *
 * @author SLA11167
 */
class SecurityController extends BaseController
{
    /**
     * 
     * @param array $data 
     */
    protected function renderLogin(array $data)
    {
        $user = $this->getUser();
        if (null != $user)
        {
            return $this->redirectToRoute('rennes_jeux_sondage_liste');
        }
        
        return $this->render('@FOSUser/Security/login.html.twig', $data);

    }
    
}
