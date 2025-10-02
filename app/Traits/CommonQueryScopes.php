<?php

namespace App\Traits;

trait CommonQueryScopes{
    public function scopeFilterByPrice($query, $min=null, $max=null){
        if(!is_null($min)) $query->where('price','>=',$min);
        if(!is_null($max)) $query->where('price','<=',$max);
        return $query;
    }

    public function scopeSearchByName($query, $term=null){
        if($term) $query->where('name','like','%'.$term.'%');
        return $query;
    }
}
