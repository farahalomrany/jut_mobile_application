<?php

namespace App\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class DestinationsFormField extends AbstractHandler
{
    protected $codename = 'Receivers';//appear in bread

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('formfields.receivers', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}
