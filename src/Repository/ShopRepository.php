<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ShopEntity;

/**
 * @method ShopEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShopEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShopEntity[]    findAll()
 * @method ShopEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopRepository extends EntityRepository
{
    public static function getEntityClass(): string
    {
        return ShopEntity::class;
    }
}
