<?php

namespace Lexik\Bundle\FormFilterBundle\Filter\Extension\Type;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Filter type for date field.
 *
 * @author Cédric Girard <c.girard@lexik.fr>
 */
class DateFilterType extends AbstractFilterType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->setAttribute('filter_options', array(
            'condition_operator' => $options['condition_operator'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver
            ->setDefaults(array(
                'transformer_id' => 'lexik_form_filter.transformer.default',
                'condition_operator' => FilterOperands::OPERATOR_EQUAL
            ))
            ->setAllowedValues(array(
                'transformer_id' => array('lexik_form_filter.transformer.default'),
                'condition_operator' => FilterOperands::getNumberOperands(true)
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'date';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'filter_date';
    }
}
