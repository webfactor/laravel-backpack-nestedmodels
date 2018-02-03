# LaravelBackpackNestedmodels

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Intuitively create tree structured models in your Backpack CRUD admin panel.

## Install

Via Composer

``` bash
$ composer require webfactor/laravel-backpack-nestedmodels
```

## Usage

If you want to easily and intuitively manage your nested models with Backpack CRUD you just need to do the following:

* Create your models migration. You can use the macro `$table->tree()` to get all necessary columns to work with [kalnoy/laravel-nestedset][link-nestedset] and this package.
* Create your BackpackCRUD controllers and models as documented in [backpack/CRUD][link-backpack-crud]
 In most cases this is just running `php artisan backpack:crud` after creating the model migration.
* Be sure your model uses `NestedModelTrait`
* Let your CrudController extend `Webfactor\Laravel\Backpack\NestedModels\Controllers\NestedModelsCrudController` instead of BaseCrudController
* Call `$this->treeSetup()` in your `setup` function **after** setting the crud model.

That's all. You are ready to see your tree structure in action. Just navigate to the appropriate route.

## Customization

You can run

```bash
$ php artisan vendor:publish --provider="Webfactor\Laravel\Backpack\NestedModels\NestedModelsServiceProvider"
```

to publish all views and edit them in 'resources/views/vendor/webfactor/nestedmodels' to customize the look and feel.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email oliver.ziegler@webfactor.de instead of using the issue tracker.

## Credits

- [Oliver Ziegler][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/webfactor/laravel-backpack-nestedmodels.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/webfactor/laravel-backpack-nestedmodels/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/webfactor/laravel-backpack-nestedmodels.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/webfactor/laravel-backpack-nestedmodels.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/webfactor/laravel-backpack-nestedmodels.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/webfactor/laravel-backpack-nestedmodels
[link-travis]: https://travis-ci.org/webfactor/laravel-backpack-nestedmodels
[link-scrutinizer]: https://scrutinizer-ci.com/g/webfactor/laravel-backpack-nestedmodels/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/webfactor/laravel-backpack-nestedmodels
[link-downloads]: https://packagist.org/packages/webfactor/laravel-backpack-nestedmodels
[link-author]: https://github.com/OliverZiegler
[link-contributors]: ../../contributors

[link-backpack-crud]: https://github.com/Laravel-Backpack/CRUD
[link-nestedset]: https://github.com/lazychaser/laravel-nestedset
