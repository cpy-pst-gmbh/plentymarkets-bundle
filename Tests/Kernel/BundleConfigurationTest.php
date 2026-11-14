<?php

namespace PM\PlentyMarketsBundle\Tests\Kernel;

use Doctrine\ORM\EntityManagerInterface;
use PM\PlentyMarketsBundle\Entity\AccessToken;
use PM\PlentyMarketsBundle\Entity\ApiHits;
use PM\PlentyMarketsBundle\Entity\ApiLock;
use PM\PlentyMarketsBundle\Entity\LimitHistory;
use PM\PlentyMarketsBundle\Repository\AccessTokenRepository;
use PM\PlentyMarketsBundle\Repository\ApiLockRepository;
use PM\PlentyMarketsBundle\Repository\LimitHistoryRepository;
use PM\PlentyMarketsBundle\Services\RestfulService;
use PM\PlentyMarketsBundle\Services\Twig\AccountsTwigExtension;
use PM\PlentyMarketsBundle\Services\Twig\ApiTwigExtension;

use function array_map;
use function sort;

/** What an application gets by registering the bundle next to Doctrine ORM. */
final class BundleConfigurationTest extends BundleKernelTestCase
{
    public function testTheOrmServicesAreWired(): void
    {
        $service = $this->service(RestfulService::class);

        self::assertSame($this->service(ApiLockRepository::class), $service->getApiLockRepository());
        self::assertSame($this->service(LimitHistoryRepository::class), $service->getLimitHistoryRepository());
        self::assertSame($this->entityManager(), $service->getObjectManager());
        self::assertInstanceOf(\Symfony\Component\Serializer\SerializerInterface::class, $service->getSerializer());
        self::assertInstanceOf(AccessTokenRepository::class, $this->service(AccessTokenRepository::class));
        self::assertInstanceOf(ApiTwigExtension::class, $this->service(ApiTwigExtension::class));
        self::assertInstanceOf(AccountsTwigExtension::class, $this->service(AccountsTwigExtension::class));
    }

    public function testTheEntitiesAreMappedToTheirTables(): void
    {
        $tables = array_map(
            fn (string $class): string => $this->entityManager()->getClassMetadata($class)->getTableName(),
            [AccessToken::class, ApiHits::class, ApiLock::class, LimitHistory::class],
        );
        sort($tables);

        self::assertSame(['pm_plenty_markets_access_token', 'pm_plenty_markets_api_hits', 'pm_plenty_markets_api_lock', 'pm_plenty_markets_limit_history'], $tables);
    }

    public function testCertificatesAreVerifiedUnlessConfiguredOtherwise(): void
    {
        self::assertTrue(self::getContainer()->getParameter('pm__plenty_market.configuration.guzzle.verify_ssl'));

        self::ensureKernelShutdown();
        self::bootKernel(['environment' => 'no_verify']);

        self::assertFalse(self::getContainer()->getParameter('pm__plenty_market.configuration.guzzle.verify_ssl'));
    }
}
