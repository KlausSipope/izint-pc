<?php declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['user'] instanceof User) {
            $lastName = $options['user']->getLastName();
            $firstName = $options['user']->getFirstName();
            $email = $options['user']->getEmail();
        }

        $builder
            ->add('lastName', TextType::class, [
                'attr'  => ['maxlength' => 40],
                'data'  => $lastName ?? '',
                'label' => 'contact.last.name'
            ])
            ->add('firstName', TextType::class, [
                'attr'  => ['maxlength' => 40],
                'data'  => $firstName ?? '',
                'label' => 'contact.first.name'
            ])
            ->add('email', EmailType::class, [
                'attr'  => ['maxlength' => 200],
                'data'  => $email ?? '',
                'label' => 'contact.email.label'
            ])
            ->add('message', TextareaType::class, [
                'attr'  => ['maxlength' => 500, 'rows' => 9],
                'label' => 'contact.message'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => null, 'user' => null]);
    }
}
