<?php

namespace MkmScraper;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    public function __toString(){
        return $this->name;
    }
}
