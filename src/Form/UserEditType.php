<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form;

use App\Entity\User;
use App\Form\Type\YesNoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Defines the form used to edit the profile of a User.
 */
class UserEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // string - length 160
            ->add('alias', TextType::class, [
                'label' => 'label.alias',
                'required' => false,
            ])
            // string - length 50
            ->add('title', TextType::class, [
                'label' => 'label.title',
                'required' => false,
            ])
            // string - length 255
            ->add('avatar', TextType::class, [
                'label' => 'label.avatar',
                'required' => false,
            ])
            // string - length 160
            ->add('email', TextType::class, [
                'label' => 'label.email',
            ])
            // boolean
            ->add('enabled', YesNoType::class, [
                'label' => 'label.active',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'edit_user_profile',
        ]);
    }
}
