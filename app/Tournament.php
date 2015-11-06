<?php

namespace MkmScraper;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $fillable=array("name","date","limited","rank");
}
