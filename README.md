# SmileEzTwitterFieldTypeBundle

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/b3954da8-43b5-4394-a233-28113d57676c/mini.png)](https://insight.sensiolabs.com/projects/b3954da8-43b5-4394-a233-28113d57676c)

This bundle aims to provide Twitter field type for eZ Platform context

## Installation

### Get the bundle using composer

Add SmileEzTwitterFieldTypeBundle by running this command from the terminal at the root of
your eZPlatform project:

```bash
composer require smile/ez-twitterfieldtype-bundle
```


### Enable the bundle

To start using the bundle, register the bundle in your application's kernel class:

```php
// ezpublish/EzPublishKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Smile\EzTwitterFieldTypeBundle\SmileEzTwitterFieldTypeBundle(),
        // ...
    );
}
```

```bash
php app/console assets:install --symlink web

php app/console assetic:dump
```
