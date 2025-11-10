<?php

namespace App\Traits;

trait Searchable
{
    public function scopeFilter($query, $filter, $column)
    {
        if ($filter && $filter !== 'all') {
            return $query->where($column, $filter);
        }

        return $query;
    }


    public function scopeSearch($query, $search, $column = 'name')
    {
        if ($search && $search !== 'all') {
            return $query->where($column, 'like', "%$search%");
        }


        return $query;
    }
}
