<?php declare(strict_types=1);

namespace App\Admin;

use App\Entity\User;
use FOS\UserBundle\Doctrine\UserManager;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
class UserAdmin extends AbstractAdmin
{
    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * @param string         $code
     * @param string        $class
     * @param string        $baseControllerName
     * @param UserManager   $userManager
     */
    public function __construct($code, $class, $baseControllerName, UserManager $userManager)
    {
        parent::__construct($code, $class, $baseControllerName);

        $this->userManager = $userManager;
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }

    /**
     * @inheritdoc
     */
    public function prePersist($object)
    {
        parent::prePersist($object);

        /** @var $object User */
        $object->setUsername($object->getEmail());
        
        $this->userManager->updateUser($object, true);
    }

    /**
     * @inheritdoc
     */
    public function preUpdate($object)
    {
        /** @var User $object */
        parent::preUpdate($object);

        /** @var $object User */
        $object->setUsername($object->getEmail());
        
        $this->userManager->updateUser($object, true);
    }

    /**
     * @inheritdoc
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('email', EmailType::class)
            ->add('firstName', TextType::class, ['attr' => ['maxlength' => 50]])
            ->add('lastName', TextType::class, ['attr' => ['maxlength' => 50]])
            ->add('description', TextareaType::class, ['required' => false, 'attr' => ['maxlength' => 500]])
            ->add('subscribed', ChoiceType::class, ['choices' => ['Yes' => 1, 'No' => 0]])
            ->add('enabled', ChoiceType::class, ['choices' => ['Yes' => 1, 'No' => 0]])
            ->add('roles', ChoiceType::class, [
                'required' => false,
                'multiple' => true,
                'choices'  => [
                    'Regular User'           => 'ROLE_USER',
                    'Company Representative' => 'ROLE_COMPANY_REPRESENTATIVE',
                    'Administrator'          => 'ROLE_ADMIN'
                ]
            ]);
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('email')
            ->add('firstName')
            ->add('lastName')
            ->add('subscribed');
    }

    /**
     * @inheritdoc
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('email')
            ->add('firstName')
            ->add('lastName')
            ->add('subscribed')
            ->add('_action', 'actions', ['actions' => ['edit' => []]]);
    }
}
