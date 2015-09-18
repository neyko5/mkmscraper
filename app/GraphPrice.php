<?php

namespace MkmScraper;

use Illuminate\Database\Eloquent\Model;

class GraphPrice extends Model
{
    protected $fillable=array("id_card","sell","date");
}
