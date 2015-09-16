<?php

namespace MkmScraper;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable=array("name","date","rank");
}
