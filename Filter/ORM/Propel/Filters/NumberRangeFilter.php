<?php

namespace Lexik\Bundle\FormFilterBundle\Filter\ORM\Propel\Filters;

use Lexik\Bundle\FormFilterBundle\Filter\ORM\Propel\PropelFilter;
use Lexik\Bundle\FormFilterBundle\Filter\ORM\Expr;

use \Criteria;

/**
 * Filter type for numbers.
 *
 * @author Cédric Girard <c.girard@lexik.fr>
 */
class NumberRangeFilter extends PropelFilter
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'filter_number_range';
    }

    /**
     * {@inheritdoc}
     */
    protected function apply(Criteria $filterBuilder, Expr $expr, $field, array $values)
    {
        $value = $values['value'];

        if(substr($field, 0 ,1) == '.') {
            $field = substr($field, 1);
        }

        if (isset($value['left_number'][0])) {
            if($value['left_number']['condition_operator'] == 'lte') $leftCond = '<=';
            else $leftCond = '>=';

            $filterBuilder->where("$field $leftCond {$value['left_number'][0]}");
        }

        if (isset($value['right_number'][0])) {
            if($value['right_number']['condition_operator'] == 'lte') $rightCond = '<=';
            else $rightCond = '>=';

            $filterBuilder->where("$field $rightCond {$value['right_number'][0]}");
        }
    }
}
