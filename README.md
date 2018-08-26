# Algolia integration with Laravel Nova.

[![Latest Stable Version](https://poser.pugx.org/nathanheffley/nova-algolia/v/stable)](https://packagist.org/packages/nathanheffley/nova-algolia?format=flat)
[![Total Downloads](https://poser.pugx.org/nathanheffley/nova-algolia/downloads)](https://packagist.org/packages/nathanheffley/nova-algolia?format=flat)

<img alt="image" src="https://raw.githubusercontent.com/NathanHeffley/nova-algolia/master/algolia-page.png">

Note: certain features on the main tool page currently only work if you use the default index name for your models. If you are setting a custom `searchableAs` value you will not be able to use the custom page. You can still use the Resource Tool.

## Installation

You can install the package in any Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require nathanheffley/nova-algolia
```

The first thing you'll need to do is register the main tool. This is usually added in the `tools` method of your `NovaServiceProvider`.

```php
// in app/Providers/NovaServiceProvider.php

public function tools()
{
    return [
        // ...

        new \NathanHeffley\NovaAlgolia\NovaAlgolia,
    ];
}
```

If you want to see search information about a `Searchable` model, you'll need to add the resource tool to that model's Nova resource.

```php
// in app/Nova/ResourceName.php

public function fields(Request $request)
{
    return [
        // ...

        \NathanHeffley\NovaAlgolia\AlgoliaResourceTool::make(),
    ];
}
```

<img alt="image" src="https://raw.githubusercontent.com/NathanHeffley/nova-algolia/master/resource-tool.png">

If you have not set up Scout or Algolia yet, follow the directions from the official instructions: [Algolia and Laravel Scout](https://www.algolia.com/doc/api-client/laravel/algolia-and-scout/).

## License

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.
