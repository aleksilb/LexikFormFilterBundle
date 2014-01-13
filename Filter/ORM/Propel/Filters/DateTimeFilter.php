<?php

namespace Lexik\Bundle\FormFilterBundle\Filter\ORM\Propel\Filters;

use \Criteria;

use Lexik\Bundle\FormFilterBundle\Filter\ORM\Propel\PropelFilter;
use Lexik\Bundle\FormFilterBundle\Filter\ORM\Expr;

class DateTimeFilter extends PropelFilter
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'filter_datetime';
    }

    /**
     * {@inheritdoc}
     */
    protected function apply(Criteria $filterBuilder, Expr $expr, $field, array $values)
    {
        if ($values['value'] instanceof \DateTime) {
            $date = $values['value']->format(Expr::SQL_DATE_TIME);
            $filterBuilder->andWhere($expr->eq($field, $expr->literal($date)));
        }
    }
}

