<?php

namespace App\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class DistributorFormField extends AbstractHandler
{
    protected $codename = 'Distributors';//appear in bread

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('formfields.distributors', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}
