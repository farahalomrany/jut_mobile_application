<?php

namespace App\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class PointsFormField extends AbstractHandler
{
    protected $codename = 'Points For Each Member';//appear in bread

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('formfields.points', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}
