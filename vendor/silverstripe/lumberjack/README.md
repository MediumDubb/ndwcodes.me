# Silverstripe Lumberjack

[![CI](https://github.com/silverstripe/silverstripe-lumberjack/actions/workflows/ci.yml/badge.svg)](https://github.com/silverstripe/silverstripe-lumberjack/actions/workflows/ci.yml)
[![Silverstripe supported module](https://img.shields.io/badge/silverstripe-supported-0071C4.svg)](https://www.silverstripe.org/software/addons/silverstripe-commercially-supported-module-list/)

A module to make managing pages in a GridField easy without losing any of the functionality that you're used to in the CMS.

This is intended to be used in cases where the SiteTree grows beyond a manageable level. eg. blogs, news sections, shops, etc.

This module was born out of and decoupled from [micmania1/silverstripe-blog](https://github.com/micmania1/silverstripe-blogger).

## Installation

```sh
composer require silverstripe/lumberjack
```

## Features

* Easily define which page types to show in the SiteTree and which to manage in a GridField.
* Keep all functionality that comes with the CMS, including versioning and preview.

## Usage

In this example we have a `NewsHolder` page which is the root of our news section, containing `NewsArticle`s and
`NewsPage`s. We want to display `NewsPage` in the site tree but we want to display `NewsArticle`s in a `GridField`.

```php
<?php

namespace MyModule\PageTypes;

use Page;
use SilverStripe\Lumberjack\Model\Lumberjack;

class NewsHolder extends Page
{
    private static $extensions = [
        Lumberjack::class,
    ];

    private static $allowed_children = [
        NewsArticle::class,
        NewsPage::class,
    ];
}
```

```php
<?php

namespace MyModule\PageTypes;

use Page;

class NewsArticle extends Page
{
    private static $show_in_sitetree = false;
    private static $allowed_children = [];
}
```

```php
<?php

namespace MyModule\PageTypes;

use Page;

class NewsPage extends Page
{
    private static $show_in_sitetree = true;
}
```

If `show_in_sitetree` is not explicitly defined on a class, then it will default to true. You can add this setting to
core classes and modules using the YAML config system. It is **not** recommended to add the LumberJack extension to
the `SiteTree` or `Page` class.

```yaml
SilverStripe\Blog\Model\Blog:
  extensions:
    - SilverStripe\Lumberjack\Model\Lumberjack

SilverStripe\Blog\Model\BlogPost:
  show_in_sitetree: false
```
