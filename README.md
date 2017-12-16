# Laravel-kdniao

Laravel Wrapper for KuaiDiNiao.


## Installing

1. require library

```shell
composer require xu42/laravel-kdniao
```

2. config

```shell
php artisan vendor:publish
```

Edit the `config/kdniao.php` file.


## Usage

1. Track

```php
KuaiDiNiao::track('SF', '12303940284', 'E201712170000001234');
```

2. Follow

```php
KuaiDiNiao::follow('SF', '12303940284', 'E201712170000001234');
```

## Others

[Official API Document](http://www.kdniao.com/api-all)


## License

[MIT](LICENSE)