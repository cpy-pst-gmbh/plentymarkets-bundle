<?php

namespace PM\PlentyMarketsBundle\Tests\Support;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;

use function dirname;
use function ksort;
use function str_replace;
use function strlen;
use function substr;

/**
 * Every class a response of plentymarkets is read into: the concrete classes under
 * Component/Model and Component/Response, by the path below Component ("Model/Order/Order"), which is
 * also the path of its fixtures.
 */
final class ModelClasses
{
    public const string FIXTURES = __DIR__.'/../Fixtures';

    /** @return array<string, class-string> path => class */
    public static function all(): array
    {
        $root = dirname(__DIR__, 2).'/Component';
        $classes = [];

        foreach (['Model', 'Response'] as $directory) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root.'/'.$directory, RecursiveDirectoryIterator::SKIP_DOTS));
            foreach ($files as $file) {
                if ('php' !== $file->getExtension()) {
                    continue;
                }
                $relative = substr($file->getPathname(), strlen($root) + 1, -4);
                $class = 'PM\\PlentyMarketsBundle\\Component\\'.str_replace('/', '\\', $relative);
                if (!(new ReflectionClass($class))->isInstantiable()) {
                    continue;
                }
                $classes[$relative] = $class;
            }
        }

        ksort($classes);

        return $classes;
    }
}
