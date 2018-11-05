<?php declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
class CreateUserCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var UserPasswordEncoderInterface
     */
    protected $encoder;

    /**
     * @param EntityManagerInterface       $entityManager
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->encoder       = $encoder;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('izint:create-user')
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create an user')
            ->setDefinition(array(
                new InputArgument('email', InputArgument::REQUIRED, 'Email'),
                new InputArgument('password', InputArgument::REQUIRED, 'Password'),
                new InputArgument('firstname', InputArgument::REQUIRED, 'First Name'),
                new InputArgument('lastname', InputArgument::REQUIRED, 'Last Name'),
                new InputArgument('description', InputArgument::OPTIONAL, 'Description'),
                new InputOption('admin', null, InputOption::VALUE_NONE, 'Set the user as admin'),
                new InputOption('regular-user', null, InputOption::VALUE_NONE, 'Set the user as regular user'),
            ));
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = new User();

        $user->setEmail($input->getArgument('email'));
        $user->setPassword($this->encoder->encodePassword($user, $input->getArgument('password')));
        $user->setFirstName($input->getArgument('firstname'));
        $user->setLastName($input->getArgument('lastname'));
        $user->setDescription($input->getArgument('description'));
        $user->addRole($this->getRoleFromInput($input));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('User has been successfully created!');
        $output->writeln('');
    }

    /**
     * @param InputInterface $input
     *
     * @return string
     */
    private function getRoleFromInput(InputInterface $input): string
    {
        return true === $input->getOption('admin') ? 'ROLE_ADMIN' : 'ROLE_USER';
    }
}
