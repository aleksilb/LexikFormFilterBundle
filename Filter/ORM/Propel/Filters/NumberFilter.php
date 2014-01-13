<?php

namespace Lexik\Bundle\FormFilterBundle\Filter\ORM\Propel\Filters;

use \Criteria;

use Lexik\Bundle\FormFilterBundle\Filter\ORM\Expr;
use Lexik\Bundle\FormFilterBundle\Filter\ORM\Propel\PropelFilter;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;

/**
 * Filter type for numbers.
 *
 * @author Cédric Girard <c.girard@lexik.fr>
 */
class NumberFilter extends PropelFilter
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'filter_number';
    }

    /**
     * {@inheritdoc}
     */
    protected function apply(Criteria $filterBuilder, Expr $expr, $field, array $values)
    {
        if ('' !== $values['value'] && null !== $values['value']) {
            switch($values['condition_operator']) {
                case FilterOperands::OPERATOR_EQUAL:
                    $value = array('min' => $values['value'], 'max' => $values['value']);
                    break;
                case FilterOperands::OPERATOR_GREATER_THAN_EQUAL:
                    $value = array('min' => $values['value']);
                    break;
                case FilterOperands::OPERATOR_GREATER_THAN:
                    $value = array('min' => $values['value'] - 0.001);
                    break;
                case FilterOperands::OPERATOR_LOWER_THAN_EQUAL:
                    $value = array('max' => $values['value']);
                    break;
                case FilterOperands::OPERATOR_LOWER_THAN:
                    $value = array('max' => $values['value'] - 0.001);
                    break;
            }

            $this->buildAndApplySearch($filterBuilder, $field, $value);
        }
    }
}
