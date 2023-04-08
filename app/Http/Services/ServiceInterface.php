<?php

namespace App\Http\Services;

interface ServiceInterface{
    public function find();
    public function create();
    public function update();
    public function delete();
}