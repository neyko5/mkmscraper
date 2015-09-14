<?php

namespace Neyko\Admin\Model;

use Illuminate\Database\Eloquent\Model;

class AdminAccess extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admin_access';

    public function module(){
    	return $this->belongsTo("\Neyko\Admin\Model\AdminModule","id_module");
    }

    public function admin(){
        return $this->belongsTo("\Neyko\Admin\Model\Administrator","id_module");
    }

    protected $fillable = array('id_admin', 'id_module');


}
