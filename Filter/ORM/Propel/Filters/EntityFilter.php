<?php

namespace Lexik\Bundle\FormFilterBundle\Filter\ORM\Propel\Filters;

use \Criteria;

use Lexik\Bundle\FormFilterBundle\Filter\ORM\Propel\PropelFilter;
use Lexik\Bundle\FormFilterBundle\Filter\ORM\Expr;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;

/**
 * Filter type for related entities.
 *
 * @author Cédric Girard <c.girard@lexik.fr>
 */
class EntityFilter extends PropelFilter
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'filter_entity';
    }

    /**
     * {@inheritdoc}
     */
    protected function apply(Criteria $filterBuilder, Expr $expr, $field, array $values)
    {
        if ('' !== $values['value'] && null !== $values['value']) {
            $peer_name = $filterBuilder->getModelPeerName();
            $table = $peer_name::getTableMap();
            if(strpos($field, '.') === 0) {
                $field = substr($field, 1);
            }
            $rel_table_class = $table->getRelation($field)
                ->getForeignTable()
                ->getClassName();
            $query_class = $rel_table_class . 'Query';
            $object = $query_class::create()->findPK($values['value']);
            $this->buildAndApplySearch($filterBuilder, $field, $object);
        }
    }
}