<?php
namespace Lexik\Bundle\FormFilterBundle\Filter\ORM\Propel;

use \Criteria;

use Lexik\Bundle\FormFilterBundle\Filter\ORM\Expr;
use Lexik\Bundle\FormFilterBundle\Event\GetFilterEvent;
use Lexik\Bundle\FormFilterBundle\Filter\FilterInterface;

abstract class PropelFilter implements FilterInterface
{
    /**
     * On filter get event
     *
     * @param GetFilterEvent $event
     */
    public function onFilterGet(GetFilterEvent $event)
    {
        if (($event->getFilterBuilder() instanceof Criteria) && $event->getName() === $this->getName()) {
            $event->setFilter($this);
            $event->stopPropagation();
        }
    }

    /**
     * Get filter type name
     *
     * @return string
     */
    abstract public function getName();

    /**
     * Apply filter: orm version of signature
     *
     * @param Criteria $filterBuilder
     * @param Expr         $expr
     * @param string       $field
     * @param array        $values
     *
     * @return void
     */
    abstract protected function apply(Criteria $filterBuilder, Expr $expr, $field, array $values);

    /**
     * {@inheritDoc}
     */
    public function applyFilter($filterBuilder, $expr, $field, array $values)
    {
        return $this->apply($filterBuilder, $expr, $field, $values);
    }

    protected function buildAndApplySearch(Criteria $filterBuilder, $field, $value)
    {
        $alias = $this->parseAliasFromField($field);
        if($alias) {
            $table = $filterBuilder->getTableForAlias($alias);
        } else {
            $table = null;
        }

        $class = $this->parseClassFromField($field);
        $filter_method = 'filterBy'.$class;

        $filterBuilder
            ->_if($alias)
                ->addAlias($alias, $table)
            ->_endif()
            ->$filter_method($value);
    }

    protected function parseAliasFromField($field) {
        if(strpos($field, '.') !== false) {
            $parts = explode('.', $field);
            return $parts[0];
        } else {
            return false;
        }
    }

    protected function parseClassFromField($field) {
        if(strpos($field, '.') !== false) {
            $parts = explode('.', $field);
            $words = explode('_', $parts[1]);
            foreach($words as &$word) {
                $word = ucfirst($word);
            }
            return implode('', $words);
        } else {
            return $field;
        }
    }
}
