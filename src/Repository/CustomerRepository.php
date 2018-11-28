<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\Activity;
use App\Entity\Customer;
use App\Entity\Project;
use App\Entity\Timesheet;
use App\Model\CustomerStatistic;
use App\Repository\Query\CustomerQuery;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Pagerfanta;

/**
 * Class CustomerRepository
 */
class CustomerRepository extends AbstractRepository
{
    /**
     * @param $id
     * @return null|Customer
     */
    public function getById($id)
    {
        return $this->find($id);
    }

    /**
     * @param null|bool $visible
     * @return int
     */
    public function countCustomer($visible = null)
    {
        if (null !== $visible) {
            return $this->count(['visible' => (int) $visible]);
        }

        return $this->count([]);
    }

    /**
     * Retrieves statistics for one customer.
     *
     * @param Customer $customer
     * @return CustomerStatistic
     */
    public function getCustomerStatistics(Customer $customer)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('COUNT(t.id) as recordAmount')
            ->addSelect('SUM(t.duration) as recordDuration')
            ->addSelect('COUNT(DISTINCT(a.id)) as activityAmount')
            ->addSelect('COUNT(DISTINCT(p.id)) as projectAmount')
            ->from(Timesheet::class, 't')
            ->join(Activity::class, 'a')
            ->join(Project::class, 'p')
            ->join(Customer::class, 'c')
            ->andWhere('t.activity = a.id')
            ->andWhere('t.project = p.id')
            ->andWhere('p.customer = c.id')
            ->andWhere('c.id = :customer')
        ;

        $result = $qb->getQuery()->execute(['customer' => $customer], Query::HYDRATE_ARRAY);

        $stats = new CustomerStatistic();

        if (isset($result[0])) {
            $dbStats = $result[0];

            $stats->setCount(1);
            $stats->setRecordAmount($dbStats['recordAmount']);
            $stats->setRecordDuration($dbStats['recordDuration']);
            $stats->setActivityAmount($dbStats['activityAmount']);
            $stats->setProjectAmount($dbStats['projectAmount']);
        }

        return $stats;
    }

    /**
     * Returns a query builder that is used for CustomerType and your own 'query_builder' option.
     *
     * @param Customer|null $entity
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function builderForEntityType(Customer $entity = null)
    {
        $query = new CustomerQuery();
        $query->setHiddenEntity($entity);
        $query->setResultType(CustomerQuery::RESULT_TYPE_QUERYBUILDER);

        return $this->findByQuery($query);
    }

    /**
     * @param CustomerQuery $query
     * @return QueryBuilder|Pagerfanta|array
     */
    public function findByQuery(CustomerQuery $query)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('c')
            ->from(Customer::class, 'c')
            ->orderBy('c.' . $query->getOrderBy(), $query->getOrder());

        if (CustomerQuery::SHOW_VISIBLE == $query->getVisibility()) {
            $qb->andWhere('c.visible = 1');

            /** @var Customer $entity */
            $entity = $query->getHiddenEntity();
            if (null !== $entity) {
                $qb->orWhere('c.id = :customer')->setParameter('customer', $entity);
            }
        } elseif (CustomerQuery::SHOW_HIDDEN == $query->getVisibility()) {
            $qb->andWhere('c.visible = 0');
        }

        if (!empty($query->getIgnoredEntities())) {
            $qb->andWhere('c.id NOT IN(:ignored)');
            $qb->setParameter('ignored', $query->getIgnoredEntities());
        }

        return $this->getBaseQueryResult($qb, $query);
    }

    /**
     * @param Customer $delete
     * @param Customer|null $replace
     * @throws \Doctrine\ORM\ORMException
     */
    public function deleteCustomer(Customer $delete, ?Customer $replace = null)
    {
        $em = $this->getEntityManager();
        $em->beginTransaction();

        try {
            if (null !== $replace) {
                $qb = $em->createQueryBuilder();
                $qb
                    ->update(Project::class, 'p')
                    ->set('p.customer', ':replace')
                    ->where('p.customer = :delete')
                    ->setParameter('delete', $delete)
                    ->setParameter('replace', $replace)
                    ->getQuery()
                    ->execute();
            }

            $em->remove($delete);
            $em->flush();
            $em->commit();
        } catch (ORMException $ex) {
            $em->rollback();
            throw $ex;
        }
    }
}
