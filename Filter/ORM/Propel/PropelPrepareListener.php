<?php
/**
 * Created by JetBrains PhpStorm.
 * User: AleksiL
 * Date: 1.7.2013
 * Time: 14:55
 */

namespace Lexik\Bundle\FormFilterBundle\Filter\ORM\Propel;

use \ModelCriteria;

use Symfony\Component\EventDispatcher\Event;

use Lexik\Bundle\FormFilterBundle\Event\PrepareEvent;

use Lexik\Bundle\FormFilterBundle\Filter\ORM\Expr;

/**
 * Prepare listener event
 */
class PropelPrepareListener
{
    /**
     * Filter builder prepare event
     *
     * @param PrepareEvent $event
     */
    public function onFilterBuilderPrepare(PrepareEvent $event)
    {
        $qb = $event->getFilterBuilder();
        if ($qb instanceof ModelCriteria) {
            $alias = $qb->getModelAlias();

            $event
                ->setAlias($alias)
                ->setExpr(new Expr);

            $event->stopPropagation();
        }
    }
}