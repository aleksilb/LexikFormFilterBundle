<?php

namespace Lexik\Bundle\FormFilterBundle\Filter\ORM\Propel\Filters;

use Lexik\Bundle\FormFilterBundle\Filter\ORM\Propel\PropelFilter;
use Lexik\Bundle\FormFilterBundle\Filter\ORM\Expr;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use \Criteria;

/**
 * Filter type for strings.
 *
 * @author Cédric Girard <c.girard@lexik.fr>
 */
class TextFilter extends PropelFilter
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'filter_text';
    }
    /**
     * {@inheritdoc}
     */
    protected function apply(Criteria $filterBuilder, Expr $expr, $field, array $values)
    {
        if ('' !== $values['value'] && null !== $values['value']) {
            switch($values['condition_pattern']) {
                case FilterOperands::STRING_EQUALS:
                    $value = $values['value'];
                    break;
                case FilterOperands::STRING_STARTS:
                    $value = $values['value'].'%';
                    break;
                case FilterOperands::STRING_ENDS:
                    $value = '%'.$values['value'];
                    break;
                case FilterOperands::STRING_BOTH:
                    $value = '%'.$values['value'].'%';
                    break;
            }
            $this->buildAndApplySearch($filterBuilder, $field, $value);
        }
    }
}
