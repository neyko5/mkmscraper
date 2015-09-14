<?php

namespace MkmScraper;

use Illuminate\Database\Eloquent\Model;

class DecklistAppearance extends Model
{
    protected $fillable=array("id_card","place","rank","number","date");

}
