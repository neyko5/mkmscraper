<?php

namespace Neyko\Admin\Model;

use Illuminate\Database\Eloquent\Model;

class AdminModule extends Model {

    protected $table = 'admin_modules';

    protected $fillable = array('name','label','singular','main','model','icon','position','parent');

    public function submodules(){
    	return $this->hasMany("\Neyko\Admin\Model\AdminModule","parent")->orderBy("position");
    }

    public function moduleparent(){
        return $this->belongsTo("\Neyko\Admin\Model\AdminModule","parent");
    }

    public function isParentOf($module){
    	return AdminModule::where("name","=",$module)->where("parent","=",$this->id)->count();
    }

}
