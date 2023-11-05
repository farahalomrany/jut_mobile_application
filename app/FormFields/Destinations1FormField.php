<?php

namespace App\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class Destinations1FormField extends AbstractHandler
{
    protected $codename = 'Destination';//appear in bread

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('formfields.destination', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}
