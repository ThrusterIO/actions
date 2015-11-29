# Actions Component

[![Latest Version](https://img.shields.io/github/release/ThrusterIO/actions.svg?style=flat-square)]
(https://github.com/ThrusterIO/actions/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)]
(LICENSE)
[![Build Status](https://img.shields.io/travis/ThrusterIO/actions.svg?style=flat-square)]
(https://travis-ci.org/ThrusterIO/actions)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/ThrusterIO/actions.svg?style=flat-square)]
(https://scrutinizer-ci.com/g/ThrusterIO/actions)
[![Quality Score](https://img.shields.io/scrutinizer/g/ThrusterIO/actions.svg?style=flat-square)]
(https://scrutinizer-ci.com/g/ThrusterIO/actions)
[![Total Downloads](https://img.shields.io/packagist/dt/thruster/actions.svg?style=flat-square)]
(https://packagist.org/packages/thruster/actions)

[![Email](https://img.shields.io/badge/email-team@thruster.io-blue.svg?style=flat-square)]
(mailto:team@thruster.io)

The Thruster Actions Component implements many different patterns, to provide universal use of this component.


## Install

Via Composer

``` bash
$ composer require thruster/actions
```

## Usage

```php
$actions = new AllAction(
    new DoctrinePersistAction(new DataModifyAction('demo_group', $object)),
    new DataIndexAction('demo_index', 'demo_type', new DataMapAction('demo_mapper', $object)),
    new DataCacheAction($object)
);

$executor->execute($actions);
```


## Testing

``` bash
$ composer test
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.


## License

Please see [License File](LICENSE) for more information.
