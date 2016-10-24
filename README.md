# SmileEzTwitterFieldTypeBundle

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/33b66272-18cb-40d2-953b-fc8baad0de02/mini.png)](https://insight.sensiolabs.com/projects/33b66272-18cb-40d2-953b-fc8baad0de02)

This bundle aims to provide Twitter field type for eZ Platform context

## Installation

### Get the bundle using composer

> This Bundle is currently in dev

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
