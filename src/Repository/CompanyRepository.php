<?php declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
class CompanyRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function all(): QueryBuilder
    {
        return $this->createQueryBuilder('c');
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @return QueryBuilder
     */
    public function filteredBy(string $field, string $value): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('c');

        return $queryBuilder
            ->andWhere($queryBuilder->expr()->like("c.{$field}", ':data'))
            ->setParameter('data', '%' . $value . '%');
    }
}
