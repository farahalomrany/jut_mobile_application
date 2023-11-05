<?php

namespace App\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class RelatedProductsFormField extends AbstractHandler
{
    protected $codename = 'Related Product';//appear in bread

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('formfields.related_products', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}
