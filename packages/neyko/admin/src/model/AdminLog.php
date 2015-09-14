<?php

namespace Neyko\Admin\Model;

use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admin_logs';

     protected $fillable = array('username', 'message');

}
