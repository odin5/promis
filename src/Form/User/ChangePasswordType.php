<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 21.08.2018 13:10
 */

namespace App\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use App\Entity\User;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'label' => 'Aktuální heslo',
                'required' => true,
                'constraints' => [ new NotBlank(), new UserPassword() ]
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Obsah polí s novým heslem se musí shodovat.',
                'required' => true,
                'first_options'  => ['label' => 'Nové heslo'],
                'second_options' => ['label' => 'Nové heslo znovu'],
            ])
            ->add('submit', SubmitType::class, array('label'  => 'Provést změnu hesla'));;
    }

//    public function setDefaultOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults([
//            'data_class' => User::class,
//        ]);
//    }
}