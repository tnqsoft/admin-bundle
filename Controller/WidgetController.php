<?php
//http://symfony.com/doc/current/book/templating.html
//http://symfony.com/doc/current/quick_tour/the_view.html
namespace TNQSoft\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class WidgetController extends Controller
{
    public function widgetNavTopAction()
    {
        $componentEnabled = $this->container->getParameter('tnq_soft_admin.component_enabled');

        return $this->render('TNQSoftAdminBundle:Widget:nav-top.html.twig', array(
            'componentEnabled' => $componentEnabled
        ));
    }
}
