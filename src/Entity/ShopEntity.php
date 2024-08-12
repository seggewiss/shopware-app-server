<?php declare(strict_types=1);

namespace Segge\AppServer\Entity;

use Doctrine\ORM\Mapping as ORM;
use Segge\AppServer\Repository\ShopRepository;
use Shopware\AppBundle\Entity\AbstractShop;
use Symfony\Contracts\Service\ResetInterface;

#[ORM\Entity(repositoryClass: ShopRepository::class)]
#[ORM\Table(name: 'shop')]
#[ORM\HasLifecycleCallbacks]
class ShopEntity extends AbstractShop implements ResetInterface
{
    public function __construct(string $shopId, string $shopUrl, string $shopSecret)
    {
        parent::__construct($shopId, $shopUrl, $shopSecret);
    }

    public function reset(): void
    {
    }
}
