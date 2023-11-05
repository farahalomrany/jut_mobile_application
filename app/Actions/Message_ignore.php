<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class Message_ignore extends AbstractAction
{
    public function getTitle()
    {
        return 'Ignore';
    }

    public function getIcon()
    {
        return 'voyager-trash';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-danger',
        ];
    }

    public function getDefaultRoute()
    {
        return route('ignoremessage', $this->data->{$this->data->getKeyName()});
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'user-messages';
    }
}