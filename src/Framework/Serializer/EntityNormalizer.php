<?php declare(strict_types=1);

namespace Segge\AppServer\Framework\Serializer;

use Shopware\AppBundle\Entity\AbstractShop;
use Segge\AppServer\Entity\Contract\EntityInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[AutoconfigureTag(name: 'serializer.normalizer')]
class EntityNormalizer implements NormalizerInterface
{
    public const ORIGINAL_DATA = 'swag_original_data';

    private const REGEX = '/.*(Segge.*)/';

    public function __construct(
        private readonly NormalizerInterface $normalizer
    ) {
    }

    /**
     * @param EntityInterface|AbstractShop $object
     * @param array<string, mixed> $context
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): string|array|\ArrayObject|bool|float|int|null
    {
        if (\array_key_exists(self::ORIGINAL_DATA, $context) && $context[self::ORIGINAL_DATA]) {
            $objectClass = $this->normalizeNamespace($object::class);
            $contextClass = $this->normalizeNamespace($context[self::ORIGINAL_DATA]::class);

            if ($objectClass !== $contextClass) {
                if ($object instanceof AbstractShop) {
                    return $object->getShopId();
                }

                return (string) $object->getId();
            }
        }

        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof EntityInterface || $data instanceof AbstractShop;
    }

    /**
     * Remove Proxies from class name.
     */
    public function normalizeNamespace(string $class): string
    {
        $matches = [];

        if (!\preg_match(self::REGEX, $class, $matches)) {
            throw new InvalidArgumentException('The class must be in namespace "Segge".');
        }

        return $matches[1];
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            AbstractShop::class => true,
            EntityInterface::class => true,
        ];
    }
}
