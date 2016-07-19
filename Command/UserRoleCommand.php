<?php

namespace TNQSoft\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TNQSoft\AdminBundle\Entity\UserRole;
use TNQSoft\AdminBundle\Entity\UserRolePermission;
use TNQSoft\AdminBundle\Constants\ConstRoles;

class UserRoleCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('tuanquynh:user:init_role')
            ->setDescription('Create User Role For TuanQuynh User Bundle');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine')->getEntityManager('default');

        //Delete All User
        $em->getConnection()->prepare('DELETE FROM user_role_permission')->execute();
        $em->getConnection()->prepare('DELETE FROM user_role')->execute();

        $listRoles = ConstRoles::getListRole();
        foreach ($listRoles as $item) {
            $role = new UserRole();
            $role->setTitle($item['title']);
            $role->setDescription($item['description']);
            foreach ($item['roles'] as $itemAction) {
                $action = new UserRolePermission();
                $action->setName($itemAction['name']);
                $action->setDescription($itemAction['description']);
                $action->setRole($role);
                $em->persist($action);
            }
            $em->persist($role);
        }
        $em->flush();
        $output->writeln('Init User Roles Successful.');
    }
}
