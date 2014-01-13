<?php

namespace Lexik\Bundle\FormFilterBundle\Filter\ORM\Propel\Filters;

use \Criteria;

use Lexik\Bundle\FormFilterBundle\Filter\ORM\Expr;
use Lexik\Bundle\FormFilterBundle\Filter\ORM\Propel\PropelFilter;

/**
 * Filter type for select list.
 *
 * @author Cédric Girard <c.girard@lexik.fr>
 */
class ChoiceFilter extends PropelFilter
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'filter_choice';
    }

    /**
     * {@inheritdoc}
     */
    protected function apply(Criteria $filterBuilder, Expr $expr, $field, array $values)
    {
        if ('' !== $values['value'] && null !== $values['value']) {
            $this->buildAndApplySearch($filterBuilder, $field, $values['value']);
        }
    }
}