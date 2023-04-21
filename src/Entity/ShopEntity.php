<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ShopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Shopware\AppBundle\Shop\ShopEntity as AppTemplateShopEntity;
use Shopware\AppBundle\Shop\ShopInterface;

#[ORM\Entity(repositoryClass: ShopRepository::class)]
#[ORM\Table(name: 'shop')]
class ShopEntity extends Entity implements ShopInterface
{
    // override auto generated id, this will be taken from shopware
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'string')]
    protected ?string $id = null;

    #[ORM\Column(name: 'shop_url', type: Types::STRING)]
    private string $shopUrl;

    #[ORM\Column(name: 'shop_secret', type: Types::STRING)]
    private string $shopSecret;

    #[ORM\Column(name: 'api_key', type: Types::STRING, nullable: true)]
    private ?string $apiKey = null;

    #[ORM\Column(name: 'secret_key', type: Types::STRING, nullable: true)]
    private ?string $secretKey = null;

    #[ORM\Column(name: 'sw_version', type: Types::STRING, nullable: true)]
    private ?string $swVersion = null;

    #[ORM\Column(name: 'app_version', type: Types::STRING, nullable: true)]
    private ?string $appVersion = null;

    public function getId(): string
    {
        return $this->id ?? '';
    }

    public function getShopUrl(): string
    {
        return $this->shopUrl;
    }

    public function setShopUrl(string $shopUrl): self
    {
        $this->shopUrl = $shopUrl;
        return $this;
    }

    public function getShopSecret(): string
    {
        return $this->shopSecret;
    }

    public function setShopSecret(string $shopSecret): self
    {
        $this->shopSecret = $shopSecret;
        return $this;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setApiKey(?string $apiKey): self
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function getSecretKey(): ?string
    {
        return $this->secretKey;
    }

    public function setSecretKey(?string $secretKey): self
    {
        $this->secretKey = $secretKey;
        return $this;
    }

    public function getSwVersion(): ?string
    {
        return $this->swVersion;
    }

    public function setSwVersion(?string $swVersion): self
    {
        $this->swVersion = $swVersion;
        return $this;
    }

    public function getAppVersion(): ?string
    {
        return $this->appVersion;
    }

    public function setAppVersion(?string $appVersion): self
    {
        $this->appVersion = $appVersion;
        return $this;
    }

    public function getConfigurations(): Collection
    {
        return $this->configurations;
    }

    public function setConfigurations(Collection $configurations): self
    {
        $this->configurations = $configurations;
        return $this;
    }

    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function setTransactions(Collection $transactions): self
    {
        $this->transactions = $transactions;
        return $this;
    }

    public function getUrl(): string
    {
        return $this->getShopUrl();
    }

    public function withApiKey(string $apiKey): ShopInterface
    {
        $this->setApiKey($apiKey);

        return $this;
    }

    public function withSecretKey(string $secretKey): ShopInterface
    {
        $this->setSecretKey($secretKey);

        return $this;
    }

    /**
     * Returns a ShopEntity compatible with the AppTemplate
     */
    public function toAppTemplateShop(): AppTemplateShopEntity
    {
        $shopId = $this->getId();

        if (!$shopId) {
            throw new \RuntimeException('Shop ID must be set at this point');
        }

        return new AppTemplateShopEntity(
            $shopId,
            $this->getShopUrl(),
            $this->getShopSecret(),
            $this->getApiKey(),
            $this->getSecretKey()
        );
    }
}
