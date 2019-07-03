<?php


namespace App\Service;


class Slugger
{
    public function slugify(string $value) {
        return preg_replace('/[^a-z0-9]/', '-', strtolower(trim(strip_tags($value))));
    }
}