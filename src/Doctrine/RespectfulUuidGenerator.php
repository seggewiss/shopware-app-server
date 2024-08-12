<?php declare(strict_types=1);

namespace Segge\AppServer\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Segge\AppServer\Entity\Contract\EntityInterface;
use Symfony\Component\Uid\Uuid;

class RespectfulUuidGenerator extends AbstractIdGenerator
{
    public function generateId(EntityManagerInterface $em, $entity): ?Uuid
    {
        if (!$entity) {
            return null;
        }

        if (!$entity instanceof EntityInterface) {
            throw new \RuntimeException(
                \sprintf(
                    'Class %s not supported for respectful uuid generation. Use %s instead',
                    $entity::class,
                    EntityInterface::class
                )
            );
        }

        return $entity->getId() ?? Uuid::v7();
    }
}
