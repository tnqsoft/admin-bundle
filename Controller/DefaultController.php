<?php

namespace TNQSoft\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="admin_dashboard")
     */
    public function indexAction()
    {
        $componentEnabled = $this->container->getParameter('tnq_soft_admin.component_enabled');
        return $this->render('TNQSoftAdminBundle:Default:index.html.twig', array(
            'componentEnabled' => $componentEnabled
        ));
    }
}
