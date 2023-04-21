<?php

declare(strict_types=1);

namespace App\Doctrine;

use App\Entity\Entity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Symfony\Component\Uid\Uuid;

class RespectfulUuidGenerator extends AbstractIdGenerator
{
    public function generate(EntityManager $em, $entity): ?string
    {
        if (!$entity) {
            return null;
        }

        if (!$entity instanceof Entity) {
            throw new \RuntimeException(
                \sprintf(
                    'Class %s not supported for respectful uuid generation. Use %s instead',
                    $entity::class,
                    Entity::class
                )
            );
        }

        return $entity->getId() ?? Uuid::v4()->toRfc4122();
    }
}
