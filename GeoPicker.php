<?php
namespace mmedojevicbg\GeoPicker;
use yii\helpers\Html;
use yii\widgets\InputWidget;
use yii\web\View;
class GeoPicker extends InputWidget
{
    /**
     * @var GeoPickerAsset
     */
    protected $asset;
    protected $fieldName;
    protected $mapId;
    protected $hiddenId;
    protected $autocompleteId;
    protected $findButtonId;
    public $apiKey;
    public function init()
    {
        parent::init();
        if ($this->hasModel()) {
            $this->fieldName = $this->attribute;
        } else {
            $this->fieldName = $this->name;
        }
        $this->createMapId();
        $this->createHiddenId();
        $this->createFindButtonId();
        $this->createAutocompleteId();
    }
    public function run()
    {
        $this->options['id'] = $this->hiddenId;
        if ($this->hasModel()) {
            echo Html::activeHiddenInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::hiddenInput($this->name, $this->value, $this->options);
        }
        $this->renderMap();
        $this->registerClientScript();
    }
    protected function registerClientScript()
    {
        $view = $this->getView();
        GeoPickerAsset::$apiKey = $this->apiKey;
        $this->asset = GeoPickerAsset::register($view);
        $js = <<<EOT
        var options = {
          map: "#{$this->mapId}",
        };
        if($("#{$this->hiddenId}").val()) {
            var arr = $("#{$this->hiddenId}").val().split(';');
            if(arr.length == 3) {
                options.location = [
                    arr[0],
                    arr[1]
                ];
            }
            $("#{$this->autocompleteId}").val(arr[2]);
        }
        $("#{$this->autocompleteId}").geocomplete(options)
          .bind("geocode:result", function(event, result){
            var lat = result.geometry.location.lat();
            var lng = result.geometry.location.lng();
            $("#{$this->hiddenId}").val(lat + ';' + lng + ';' + $("#{$this->autocompleteId}").val());
          });
        $("#{$this->findButtonId}").click(function(){
          $("#{$this->autocompleteId}").trigger("geocode");
        });
EOT;
        $view->registerJs($js, View::POS_LOAD);  
    }
    protected function renderMap()
    {
        echo Html::textInput($this->autocompleteId, null, [
            'id' => $this->autocompleteId,
            'placeholder' => 'Type in an address',
            'class' => 'geocomplete'
        ]);
        echo Html::button('Find', [
            'id' => $this->findButtonId
        ]);
        echo Html::beginTag('div', ['id' => $this->mapId, 'class' => 'map_canvas']);
        echo Html::endTag('div');
    }
    protected function createMapId() {
        return $this->mapId = 'geo-picker-map-' . $this->fieldName;
    }
    protected function createHiddenId() {
        return $this->hiddenId = 'geo-picker-hidden-' . $this->fieldName;
    }
    protected function createFindButtonId() {
        return $this->findButtonId = 'geo-picker-find-button-' . $this->fieldName;
    }
    protected function createAutocompleteId() {
        return $this->autocompleteId = 'geo-picker-autocomplete-' . $this->fieldName;
    }
}