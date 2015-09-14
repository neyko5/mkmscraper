<?php

namespace Neyko\Admin\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Administrator extends Model implements AuthenticatableContract, CanResetPasswordContract  {

    use Authenticatable, CanResetPassword;

    protected $table = 'admins';

    protected $hidden = array('remember_token');

    protected $fillable = array('username','password','email','lang');

    public function modules()
    {
        return $this->belongsToMany('Neyko\Admin\Model\AdminModule','admin_access','id_admin','id_module')->where("parent","=","0")->orderBy("position","ASC");
    }

    public function hasAccessToModule($module){
        return AdminAccess::where("id_admin","=",$this->id)->where("id_module","=",$module)->count()>0;
    }

}
