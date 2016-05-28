<?php

namespace TNQSoft\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TNQSoft\AdminBundle\Entity\User;

class UserCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('tuanquynh:user:create')
            ->setDescription('Create User For TuanQuynh User Bundle')
            ->addArgument(
                'username',
                InputArgument::REQUIRED,
                "User's Username"
            )
            ->addArgument(
                'password',
                InputArgument::REQUIRED,
                "User's Password"
            )
            ->addArgument(
                'email',
                InputArgument::REQUIRED,
                "User's Email"
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $email = $input->getArgument('email');

        $container = $this->getContainer();
        $em = $container->get('doctrine')->getEntityManager('default');
        $passwordEncoder = $container->get('security.password_encoder');

        $user = new User();
        $password = $passwordEncoder->encodePassword($user, $password);
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setEmail($email);

        $em->persist($user);
        $em->flush();

        $output->writeln('Create User Successful.');
    }
}
