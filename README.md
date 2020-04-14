# yii2-module-banner

[![Latest Stable Version](https://poser.pugx.org/floor12/yii2-module-banner/v/stable)](https://packagist.org/packages/floor12/yii2-module-banner)
[![Latest Unstable Version](https://poser.pugx.org/floor12/yii2-module-banner/v/unstable)](https://packagist.org/packages/floor12/yii2-module-banner)
[![Total Downloads](https://poser.pugx.org/floor12/yii2-module-banner/downloads)](https://packagist.org/packages/floor12/yii2-module-banner)
[![License](https://poser.pugx.org/floor12/yii2-module-banner/license)](https://packagist.org/packages/floor12/yii2-module-banner)

Модуль для размещения и управления баннерами и поп-ап на сайте. 
Оперирует с тремя сущностями - площадками (местами установки баннера на сайте), классическими и pop-up баннерами.


Установка
------------

#### Ставим модуль

Выполняем команду
```bash
$ composer require floor12/yii2-module-banner
```

иди добавляем в секцию "requred" файла composer.json
```json
"floor12/yii2-module-banner": "dev-master"
```


#### Выполняем миграцию для созданию необходимых таблиц
```bash
$ ./yii migrate --migrationPath=@vendor/floor12/yii2-module-banner/src/migrations
```

#### Добавляем модуль в конфиг приложения
```php  
'modules' => [
        'banner' => [
            'class' => 'floor12\banner\Module',
            'editRole' => 'admin',
            'layout' => '@frontend/views/layouts/columns'
        ],
    ]
    ...
```

Обязательные параметры:

1. **editRole** - роль пользователей, которым доступно управление. Можно использовать "@".
2. **layout** - путь для лейаута, используемой в админском контроллере.

Использование
-----
Для внедрения в view-файл баннера, вызываем `BannerWidget` виджет показа баннера в нужном месте, где **place_id** - это id площадки для размещения. 


```php  
<?= floor12\banner\widgets\BannerWidget::widget(['place_id' => 1]) ?>
```

Если площадка не найдена, или в ней отсутствуют связанные баннеры, то виджет ничего не отобразит.

Если на одну и ту же площадку добавлено более одного активного баннера, то существуют две модели поведения.
По умолчанию, баннеры будут рандомно меняться при перезагрузке страницы. Но, если в настройках площадки выбрать 
"слайдер", то все активные баннеры текущей площадки будут перелистываться, образуя слайдер.

Для отображения pop-up баннеров, необходимо в основной layout вывести `PopupWidget`:
```
<?php
    $this->beginBody();
    echo PopupWidget::widget([]);
?>
```

### Управление

По умолчанию админский контроллер доступен по адресу:
```
http://your-domain.com/banner/admin
```

При редактировании рекламной площадки, можно выбрать для нее режим слайдера с дополнительными настройками.

