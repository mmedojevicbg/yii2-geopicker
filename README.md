Geo Picker - Yii2 extension
=====

This is a form widget which displays Google map and store data as latitude/longitude pair. 

Installation
---

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist mmedojevicbg/yii2-geopicker "dev-master"
```

or add

```
"mmedojevicbg/yii2-geopicker": "dev-master"
```

to the require section of your `composer.json` file.

Usage
---

```php
$form->field($model, 'location1')->widget(mmedojevicbg\GeoPicker\GeoPicker::className(), [
	'apiKey' => 'YOUR_API_KEY'
])
```