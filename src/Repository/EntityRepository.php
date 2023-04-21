<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Entity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

abstract class EntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->getEntityClass());
    }

    /**
     * @return class-string
     */
    abstract public static function getEntityClass(): string;

    public function findByIds(array $ids): array
    {
        $ids = \array_map(function (string $id) {
            // doctrine automagically finds entities with their string uuid representation when using ->find()
            // however, somehow doctrine needs uuids in binary representation when using ->findBy()
            // convert the id to a binary uuid, when it is a valid uuid string representation
            if (Uuid::isValid($id)) {
                return Uuid::fromString($id)->toBinary();
            }

            return $id;
        }, $ids);

        return $this->findBy([$this->getClassMetadata()->getSingleIdentifierFieldName() => $ids]);
    }

    public function persist(Entity $entity): void
    {
        $this->_em->persist($entity);
    }

    public function remove(Entity $entity): void
    {
        $this->_em->remove($entity);
    }

    public function flush(): void
    {
        $this->_em->flush();
    }
}
