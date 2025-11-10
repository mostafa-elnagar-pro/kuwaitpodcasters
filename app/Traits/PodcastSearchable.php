<?php

namespace App\Traits;

trait PodcastSearchable
{
    public function scopeFilter($query, $filter, $column)
    {
        if ($filter && $filter !== 'all') {
            return $query->where($column, $filter);
        }

        return $query;
    }


    public function scopeSearch($query, $search, $column = 'name', $options = null)
    {
        if ($search) {
            $query->where($column, 'like', "%$search%");

            if ($options) {
                $query->orWhereHas($options['relation'], $options['closure']);
            }
        }

        return $query;
    }



}
