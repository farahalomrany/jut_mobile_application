<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class Message_answer extends AbstractAction
{
    public function getTitle()
    {
        return 'Answer';
    }

    public function getIcon()
    {
        return 'voyager-edit';
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
        return route('answermessage', $this->data->{$this->data->getKeyName()});
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'user-messages';
    }
}