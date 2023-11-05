<?php

namespace App\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class GiftsFormField extends AbstractHandler
{
    protected $codename = 'Gifts';//appear in bread

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('formfields.gifts', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}
