<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\BaseController;
use Illuminate\Database\Eloquent\Model;

class GiftNameInx extends Model
{
    use HasFactory, HasApiTokens;
    
    protected $table = "gifts_names_inx";
    
    protected $fillable = ['name','image','description'];

    public function gifts()
    {
         return $this->hasMany(Gift::class);
    }

    public static function boot()
    {
       
        $class = static::class;
        parent::boot();
        static::deleting(function($model)
        {
            
            $gift_id = $model->id;
            $gifts = Gift::where('gift_name_inx_id',$gift_id)->get();
           
            if(count($gifts) > 0){
                
                return redirect()->back()->with([
                    'message'    => __('You can not delete this gift !!!!!'),
                    'alert-type' => 'error',
                ]);
           
            }
            

        });
    } 
    


}
