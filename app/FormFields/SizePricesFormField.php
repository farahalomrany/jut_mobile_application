<?php

namespace App\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class SizePricesFormField extends AbstractHandler
{
    protected $codename = 'Size Price';//appear in bread

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('formfields.sizeprices', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}
