<?php

namespace Ahlin\Bundle\CoreBundle\Tests\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DummyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',       'text')
                ->add('email',      'email')
                ->add('check',      'checkbox')
                ->add('count_one',  'integer')
                ->add('count_two',  'integer');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'allow_extra_fields' => true,
            'ignore_extra_data' => true,
            'data_class'        => 'Ahlin\Bundle\CoreBundle\Tests\Entity\Dummy',
            'error_mapping'     => array(
                'countTwoBigger' => 'count_two',
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ahlin_core_dummy';
    }
}
