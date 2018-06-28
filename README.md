# QuickBrownFox Codeception Helper
Codeception Helper for [QuickBrownFox](https://packagist.org/packages/lapaz/quick-brown-fox).

## Installation
```$xslt
composer require ippey/quick-brown-fox-codeception-helper
```
## Configuration
For example.
```yaml
modules:
    enabled: [QuickBrownFoxHelper]
    config:
        QuickBrownFoxHelper:
          dsn: 'mysql:host=localhost;dbname=test'
          user: 'user'
          password: 'password'
```

## Usage
```php
// Using Helper
$this->>tester->setFixtures('table', [
    [
        'id' => 1,
        'name' => 'my name',
        'gender' => 'male',
    ],
]);

// Using FixtureSetupSession
$this->tester->newFixtureSession();
$session = $this->>tester->getFixtureSession();
$session->into('table')->load([
    [
        'id' => 1,
        'name' => 'my name',
        'gender' => 'male',
    ],
]);

// If you want to reset data, use resetFixtureSession()
$this->>tester->resetFixtureSession();

```

more details, See [QuickBrownFox Documentation](https://github.com/LapazPhp/QuickBrownFox).

## License
MIT License