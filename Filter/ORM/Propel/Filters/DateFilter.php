<?php

namespace Lexik\Bundle\FormFilterBundle\Filter\ORM\Propel\Filters;

use \Criteria;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\ORM\Propel\PropelFilter;
use Lexik\Bundle\FormFilterBundle\Filter\ORM\Expr;

class DateFilter extends PropelFilter
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'filter_date';
    }

    /**
     * {@inheritdoc}
     */
    protected function apply(Criteria $filterBuilder, Expr $expr, $field, array $values)
    {
        if ($values['value'] instanceof \DateTime) {
            switch($values['condition_operator']) {
                case FilterOperands::OPERATOR_EQUAL:
                    $value = $values['value'];
                    break;
                case FilterOperands::OPERATOR_GREATER_THAN:
                    $value = array('min' => $values['value']);
                    break;
                case FilterOperands::OPERATOR_LOWER_THAN:
                    $value = array('max' => $values['value']);
                    break;
            }
            $this->buildAndApplySearch($filterBuilder, $field, $value);
        }
    }
}
