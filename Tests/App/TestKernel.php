<?php

namespace PM\PlentyMarketsBundle\Tests\App;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use JMS\SerializerBundle\JMSSerializerBundle;
use PM\PlentyMarketsBundle\PMPlentyMarketsBundle;
use PM\PlentyMarketsBundle\Services\RestfulService;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel;

use function str_starts_with;
use function dirname;

/**
 * An application as small as it gets, with the bundle set up as the shop and the helpdesk set
 * it up: Doctrine ORM (here on SQLite in memory), the JMS serializer with the names as they are,
 * and the bundle's own configuration. Only plentymarkets is played: RestfulService makes its
 * Guzzle clients with KernelRestfulService's MockHandler.
 *
 * The environment "no_verify" sets pm_plenty_markets.guzzle.verify_ssl to false.
 */
final class TestKernel extends Kernel implements CompilerPassInterface
{
    use MicroKernelTrait;

    public function registerBundles(): iterable
    {
        yield new FrameworkBundle();
        yield new DoctrineBundle();
        yield new JMSSerializerBundle();
        // After Doctrine: the bundle's extension looks for its parameters to choose ORM or ODM.
        yield new PMPlentyMarketsBundle();
    }

    public function getProjectDir(): string
    {
        return __DIR__;
    }

    /** In var/ of the bundle (ignored by git); emptied, the next run builds the container anew. */
    public function getCacheDir(): string
    {
        return dirname(__DIR__, 2).'/var/cache/'.$this->environment;
    }

    public function getLogDir(): string
    {
        return dirname(__DIR__, 2).'/var/log';
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->extension('framework', [
            'test' => true,
            'secret' => 'test',
            'http_method_override' => false,
            'handle_all_throwables' => true,
            'php_errors' => ['log' => true],
        ]);

        $container->extension('doctrine', [
            'dbal' => ['url' => 'sqlite:///:memory:'],
            'orm' => [
                // As the shop and the helpdesk have it: the bundle's entities are found by itself.
                'auto_mapping' => true,
            ],
        ]);

        $container->extension('jms_serializer', [
            'property_naming' => [
                'id' => 'jms_serializer.identical_property_naming_strategy',
                'separator' => '',
                'lower_case' => false,
            ],
        ]);

        if ('no_verify' === $this->environment) {
            $container->extension('pm_plenty_markets', ['guzzle' => ['verify_ssl' => false]]);
        }
    }

    /** The double for plentymarkets, and the bundle's services public, so that tests can take them. */
    public function process(ContainerBuilder $container): void
    {
        $container->getDefinition(RestfulService::class)->setClass(KernelRestfulService::class);

        foreach ($container->getDefinitions() as $id => $definition) {
            if (str_starts_with($id, 'PM\\PlentyMarketsBundle\\')) {
                $definition->setPublic(true);
            }
        }
    }
}
