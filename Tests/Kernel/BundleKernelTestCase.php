<?php

namespace PM\PlentyMarketsBundle\Tests\Kernel;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use PM\PlentyMarketsBundle\Tests\App\KernelRestfulService;
use PM\PlentyMarketsBundle\Tests\App\TestKernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * The bundle inside TestKernel, with a fresh SQLite database in memory for every test: the
 * schema comes from the bundle's own mapping, as an application's migrations would make it.
 */
abstract class BundleKernelTestCase extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return TestKernel::class;
    }

    protected function setUp(): void
    {
        KernelRestfulService::reset();
        self::bootKernel();

        $entityManager = $this->entityManager();
        $schema = new SchemaTool($entityManager);
        $schema->createSchema($entityManager->getMetadataFactory()->getAllMetadata());
    }

    protected function entityManager(): EntityManagerInterface
    {
        return self::getContainer()->get(EntityManagerInterface::class);
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $id
     *
     * @return T
     */
    protected function service(string $id): object
    {
        return self::getContainer()->get($id);
    }

    /** Persisted and flushed, then forgotten by the entity manager, so that reads go to the database. */
    protected function store(object ...$objects): void
    {
        foreach ($objects as $object) {
            $this->entityManager()->persist($object);
        }
        $this->entityManager()->flush();
        $this->entityManager()->clear();
    }
}
