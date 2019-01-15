<?php declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
class UserRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function getSubscribedUsers() : array
    {
        return $this->createQueryBuilder('u')
            ->select('u.email')
            ->andWhere('u.subscribed = 1')
            ->getQuery()->getResult();
    }
}
