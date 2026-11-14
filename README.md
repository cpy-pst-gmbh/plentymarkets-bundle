# Plentymarketsbundle

## Einrichtung

```bash
composer require cpy-pst-gmbh/plentymarkets-bundle
```

Das Bundle in `config/bundles.php` **nach** dem DoctrineBundle eintragen. Die Extension
erkennt am Doctrine-Bundle, ob Tokens, Sperren und Limits mit dem ORM oder mit MongoDB (ODM)
gespeichert werden, und lädt `Resources/config/services_orm.yml` bzw. `services_odm.yml`.

```php
Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
PM\PlentyMarketsBundle\PMPlentyMarketsBundle::class => ['all' => true],
```

Optional, `config/packages/pm_plenty_markets.yaml`:

```yaml
pm_plenty_markets:
    guzzle:
        verify_ssl: true   # Standard
```

Die Tabellen (`pm_plenty_markets_access_token`, `_api_hits`, `_api_lock`, `_limit_history`)
bringt die App mit ihren Migrationen an, aus dem Mapping der Entities in `Entity/`.

Abgefragt wird über `RestfulService` mit einer `Component\Config` je plentymarkets-Zugang:

```php
$orders = $restfulService->orders(new Config($url, $user, $password, 0.3, 0.2));
```

Die beiden Anteile sind die Sperrgrenzen: Bleiben weniger als 30 % des Stundenlimits oder
20 % des kurzen Limits, nimmt das Bundle keine weiteren Aufrufe an, bis das Limit sich erholt
hat. In einer Web-Anfrage `->setWait(false)` setzen: Dann kehrt jeder Aufruf sofort zurück
statt bei einer Sperre, einem 429, einem Verbindungsfehler oder einem 5xx zu warten (#54).

## Serializer

Die Antworten liest der Symfony Serializer, den das Bundle selbst baut
(`Component\Serializer\SerializerFactory`, Dienst `pm_plenty_markets.serializer`); die App
muss keinen konfigurieren, und ihr eigener bleibt unberührt.

- Die Typen kommen allein aus den Properties der Modelle: Deklaration und `@var`
  (`list<Klasse>` für Listen), auch bei Properties einer Elternklasse.
- Geschrieben wird per Reflection, an Settern vorbei (`ModelNormalizer`), Namen wie die
  Property oder `#[SerializedName]`, ein Datumsformat über `#[Context]`.
- Nachsichtig wie zuvor JMS: `"5"` wird zu `5`, `7` zu `7.0`; ein `null` für eine Property,
  die keins halten kann, wird ausgelassen; unbekannte Felder werden ignoriert.

## Upgrade von 1.x auf 2.0

- **JMS entfällt** (#58). `RestfulService::getSerializer()` gibt
  `Symfony\Component\Serializer\SerializerInterface` zurück, der Konstruktor erwartet ihn.
  Die App kann `jms/serializer-bundle` und seine Konfiguration entfernen, wenn sie JMS sonst
  nicht nutzt.
- Das Bundle überschreibt den Dienst `jms_serializer.serialized_name_annotation_strategy` nicht
  mehr. Nutzt die App JMS selbst, gilt dort wieder ihre eigene Namensstrategie.
- Modelle: Aus `#[JMS\Type]` sind typisierte, nullbare Properties geworden; die Getter und
  Setter sind unverändert.
- Abhängigkeiten stehen jetzt vollständig in `require`, darunter `symfony/yaml` (#66).
- Symfony 8 ist Voraussetzung.

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
- **Im Kernel** (`Tests/Kernel`): das Bundle in einer kleinen Symfony-Anwendung
  (`Tests/App/TestKernel`) mit Doctrine ORM auf SQLite im Arbeitsspeicher, wie Shop und Helpdesk
  es einbinden. Geprüft werden die Extension und die Verdrahtung, die Repositories mit ihren
  Abfragen (Token, Sperren, Limit-Historie, API-Hits) und der ganze Weg: Token behalten, Limits
  schreiben, Sperre für die nächste Anfrage. Nur plentymarkets ist gespielt
  (`KernelRestfulService`). Der MongoDB-Teil (`Document`, `DocumentRepository`) ist nicht
  getestet.
- **Coverage** mit PCOV, mit leerem `var/`, damit der Container neu gebaut und die Extension
  mitgezählt wird: `rm -rf var && php -d pcov.enabled=1 vendor/bin/phpunit --coverage-html var/coverage`.
  Die Getter und Setter der Modelle zählen kaum mit, weil der Serializer per Reflection
  schreibt; sie prüfen die Golden-Master-Tests.
- **Login, Fehlertexte, Warten** (`LoginTest`, `ResponseHelperTest`, `WaitTest`).
