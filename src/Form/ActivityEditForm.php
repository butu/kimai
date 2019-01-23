<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form;

use App\Entity\Activity;
use App\Form\Type\CustomerType;
use App\Form\Type\ProjectType;
use App\Form\Type\YesNoType;
use App\Repository\CustomerRepository;
use App\Repository\ProjectRepository;
use App\Repository\Query\ProjectQuery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Defines the form used to manipulate Activities.
 */
class ActivityEditForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Activity $entry */
        $entry = $options['data'];

        $project = null;
        $customer = null;
        $currency = false;

        if (null !== $entry->getProject()) {
            $project = $entry->getProject();
            $customer = $project->getCustomer();
            $currency = $customer->getCurrency();
        }

        $builder
            // string - length 255
            ->add('name', TextType::class, [
                'label' => 'label.name',
            ])
            // text
            ->add('comment', TextareaType::class, [
                'label' => 'label.comment',
                'required' => false,
            ])
            ->add('customer', CustomerType::class, [
                'label' => 'label.customer',
                'query_builder' => function (CustomerRepository $repo) use ($customer) {
                    return $repo->builderForEntityType($customer);
                },
                'data' => $customer ? $customer : null,
                'required' => false,
                'mapped' => false,
                'project_enabled' => true,
            ])
            ->add('project', ProjectType::class, [
                'label' => 'label.project',
                'required' => false,
                'query_builder' => function (ProjectRepository $repo) use ($project, $customer) {
                    return $repo->builderForEntityType($project, $customer);
                },
            ]);

        // replaces the project select after submission, to make sure only projects for the selected customer are displayed
        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($project) {
                $data = $event->getData();
                if (!isset($data['customer']) || empty($data['customer'])) {
                    return;
                }

                $event->getForm()->add('project', ProjectType::class, [
                    'group_by' => null,
                    'query_builder' => function (ProjectRepository $repo) use ($data, $project) {
                        return $repo->builderForEntityType($project, $data['customer']);
                    },
                ]);
            }
        );

        $builder
            ->add('fixedRate', MoneyType::class, [
                'label' => 'label.fixed_rate',
                'required' => false,
                'currency' => $currency,
            ])
            ->add('hourlyRate', MoneyType::class, [
                'label' => 'label.hourly_rate',
                'required' => false,
                'currency' => $currency,
            ])
            // boolean
            ->add('visible', YesNoType::class, [
                'label' => 'label.visible',
            ])
        ;

        if (null === $entry->getId()) {
            $builder->add('create_more', CheckboxType::class, [
                'label' => 'label.create_more',
                'required' => false,
                'mapped' => false,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'admin_activity_edit',
        ]);
    }
}
