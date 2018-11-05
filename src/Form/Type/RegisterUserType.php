<?php declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'passwords.fields.must.match',
                'options' => array('attr' => array('class' => 'password-field')),
                'first_options'  => array('label' => 'password'),
                'second_options' => array('label' => 'repeat.password'),
            ])
            ->add('firstName', TextType::class, ['attr' => ['maxlength' => 50], 'label' => 'first.name'])
            ->add('lastName', TextType::class, ['attr' => ['maxlength' => 50], 'label' => 'last.name'])
            ->add('description', TextareaType::class, [
                'attr' => ['maxlength' => 500, 'rows' => 7],
                'required' => false,
                'label' => 'description'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => User::class]);
    }
}
