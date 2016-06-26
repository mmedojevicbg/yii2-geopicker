<?php
namespace mmedojevicbg\GeoPicker;
use yii\web\AssetBundle;
class GeoPickerAsset extends AssetBundle
{
    public static $apiKey = '';
    public $js;
    public $css = [
        'style.css'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ];
    public function init()
    {
        $this->js = [
            "http://maps.googleapis.com/maps/api/js?key=" . self::$apiKey . "&libraries=places",
            'jquery.geocomplete.js'
        ];
        $this->sourcePath = __DIR__ . '/assets';
        parent::init();
    }
}