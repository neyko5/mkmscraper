<?php

namespace MkmScraper;

use Illuminate\Database\Eloquent\Model;

class CardPrice extends Model
{
    protected $fillable=array("id_card","sell","low","lowex","lowfoil","avg","trend","sellers");
}
