<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AdminMessage extends Model
{
    use HasFactory, HasApiTokens;

    public function save(array $options = [])
    {
        // Do whatever you want
        $this->receivers = json_encode(request()->input('receivers'));
        $this->destination = json_encode(request()->input('destination'));

        parent::save();
    }

    protected $fillable = ['date', 'destination', 'receivers','text','admin_id','title'
                          ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public static function boot()
    {
        $class = static::class;
        parent::boot();
        static::creating(function ($model) {
            $model->admin_id = auth()->user()->id;
            $model->date = Carbon::now()->toDateString();

        });

    }

    public function destination_json($destination)
    {
        $details_string = "";
       
        foreach (json_decode($destination, true) as $key => $value) {
            $s = isset($value['name']) ? $value['name'] : "";
            $details_string = $details_string . "destination to : {$s}   ";
         

        }
      

        return $details_string;
    }
    // public function getDestinationAttribute()
    // {
    //     return $this->destination_json($this->attributes['destination']) ;
    // }

    public function receivers_json($receivers)
    {
        $details_string = "";
      
        foreach (json_decode($receivers, true) as $key => $value) {
            $s = isset($value['id']) ? $value['id'] : "";
            $details_string = $details_string . "id : {$value["id"]}   ";
           
        }
    

        return $details_string;
    }
    // public function getReceiversAttribute()
    // {
    //     return $this->receivers_json($this->attributes['receivers']) ;
    // }

}