<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class Products extends AbstractAction
{
    public function getTitle()
    {
        return 'Products';
    }

    public function getIcon()
    {
        return 'voyager-eye';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary',
        ];
    }

    public function getDefaultRoute()
    {
        return route('products', $this->data->{$this->data->getKeyName()});
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'campaigns';
    }
}