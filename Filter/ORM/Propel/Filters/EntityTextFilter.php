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
class EntityTextFilter extends PropelFilter
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'filter_entity_text';
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

            $peer_name = $filterBuilder->getModelPeerName();
            $table = $peer_name::getTableMap();
            if(strpos($field, '.') === 0) {
                $field = substr($field, 1);
            }
            $rel_table = $table->getRelation($field)
                ->getForeignTable();
            $label_fields = array();
            foreach($rel_table->getColumns() as $column) {
                if($column->isPrimaryString()) {
                    $label_fields[] = $column->getPhpName();
                }
            }
            $query_class_method = 'use' . ucfirst($rel_table->getPhpName()) . 'Query';
            $filterBuilder = $filterBuilder->$query_class_method();
            foreach($label_fields as $label_field) {
                $this->buildAndApplySearch($filterBuilder->_or(), $label_field, $value);
            }
            $filterBuilder = $filterBuilder->endUse();
        }
    }
}