<?php
namespace Lexik\Bundle\FormFilterBundle\Filter\ORM\Propel;

use \Criteria;

use Symfony\Component\EventDispatcher\Event;

use Lexik\Bundle\FormFilterBundle\Event\PrepareEvent;

use Lexik\Bundle\FormFilterBundle\Filter\ORM\Expr;

/**
 * Prepare listener event
 */
class PrepareListener
{
    /**
     * Filter builder prepare event
     *
     * @param PrepareEvent $event
     */
    public function onFilterBuilderPrepare(PrepareEvent $event)
    {
        $qb = $event->getFilterBuilder();
        if ($qb instanceof Criteria) {
            /*$aliases = $qb->getRootAliases();
            $alias   = isset($aliases[0]) ? $aliases[0] : '';*/
            $alias = '';

            $event
                ->setAlias($alias)
                ->setExpr(new Expr);

            $event->stopPropagation();
        }
    }
}
