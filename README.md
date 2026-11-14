# Plentymarketsbundle

## Config

### services.yaml

Mongo:

    PM\PlentyMarketsBundle\Services\Twig\AccountsTwigExtension:
        tags: [ { name: twig.extension } ]
    
    PM\PlentyMarketsBundle\Services\Twig\ApiTwigExtension:
        arguments:
            $apiLockRepository: '@PM\PlentyMarketsBundle\DocumentRepository\ApiLockRepository'

    jms_serializer.serialized_name_annotation_strategy:
        class: JMS\Serializer\Naming\SerializedNameAnnotationStrategy
        arguments:
            - '@jms_serializer.identical_property_naming_strategy'
        
    PM\PlentyMarketsBundle\Services\RestfulService:
        arguments:
            $accessTokenRepository: '@PM\PlentyMarketsBundle\DocumentRepository\AccessTokenRepository'
            $apiHitsRepository: '@PM\PlentyMarketsBundle\DocumentRepository\ApiHitsRepository'
            $apiLockRepository: '@PM\PlentyMarketsBundle\DocumentRepository\ApiLockRepository'
            $limitHistoryRepository: '@PM\PlentyMarketsBundle\DocumentRepository\LimitHistoryRepository'
            $serializer: '@jms_serializer.serializer'
            $objectManager: '@Doctrine\ODM\MongoDB\DocumentManager'
            $logger: '@logger'
            $parameterGuzzleVerifySsl: '%pm__plenty_market.configuration.guzzle.verify_ssl%'

Sql:

    PM\PlentyMarketsBundle\Services\Twig\AccountsTwigExtension:
        tags: [ { name: twig.extension } ]
    
    PM\PlentyMarketsBundle\Services\Twig\ApiTwigExtension:
        arguments:
            $apiLockRepository: '@PM\PlentyMarketsBundle\Repository\ApiLockRepository'

    jms_serializer.serialized_name_annotation_strategy:
        class: JMS\Serializer\Naming\SerializedNameAnnotationStrategy
        arguments:
            - '@jms_serializer.identical_property_naming_strategy'
        
    PM\PlentyMarketsBundle\Services\RestfulService:
        arguments:
            $accessTokenRepository: '@PM\PlentyMarketsBundle\Repository\AccessTokenRepository'
            $apiHitsRepository: '@PM\PlentyMarketsBundle\Repository\ApiHitsRepository'
            $apiLockRepository: '@PM\PlentyMarketsBundle\Repository\ApiLockRepository'
            $limitHistoryRepository: '@PM\PlentyMarketsBundle\Repository\LimitHistoryRepository'
            $serializer: '@jms_serializer.serializer'
            $objectManager: '@Doctrine\ORM\EntityManagerInterface'
            $logger: '@logger'
            $parameterGuzzleVerifySsl: '%pm__plenty_market.configuration.guzzle.verify_ssl%'

## Tests

```bash
composer install
vendor/bin/phpunit
```

Die CI (`.github/workflows/ci.yml`) führt sie auf jedem Push und Pull Request aus, unter PHP 8.4
und 8.5, jeweils mit Guzzle 7 und 8, auf GitHubs eigenen Runnern (das Repo ist öffentlich).

- **Modelle** (`ModelDeserializationTest`): Für jede Klasse unter `Component/Model` und
  `Component/Response` liegt in `Tests/Fixtures` eine Antwort, die jedes Feld setzt
  (`<Klasse>.json`), und das Objekt, das daraus werden muss (`<Klasse>.expected.json`, jede
  Property per Reflection). Die Werte sind erfunden, keine echten Daten.
  - Ein neues Modell braucht eine Fixture, sonst schlägt der Test fehl. Erzeugt wird sie mit
    `php Tests/bin/generate-model-fixtures.php` aus den Serializer-Metadaten des Modells.
  - Die `.expected.json` sind der Sollzustand: einmal erzeugt, im Diff geprüft, dann
    committet. Ändert ein Umbau sie, sagt der Diff, was anders gelesen wird. Neu schreiben nur
    mit Absicht: `--expected` (nur Sollzustände) oder `--all` (auch die Antworten).
- **Provider** (`Tests/Provider`): jede öffentliche Methode jedes Providers, mit Anfrage
  (Methode, Pfad, Query, Body), Ergebnis, Blättern und Fehlerweg; dazu die Buchführung der
  API-Limits und die Sperren in `BaseProvider`. plentymarkets spielt Guzzles `MockHandler`
  (`ProviderTestCase`, `Tests/Support/MockedRestfulService`). Die Tests halten das heutige
  Verhalten fest, auch wo es fragwürdig ist.
- **Coverage** mit PCOV: `php -d pcov.enabled=1 vendor/bin/phpunit --coverage-html var/coverage`.
  Die Getter und Setter der Modelle zählen kaum mit, weil der Serializer per Reflection
  schreibt; sie prüfen die Golden-Master-Tests.
- **Login, Fehlertexte, Warten** (`LoginTest`, `ResponseHelperTest`, `WaitTest`).
