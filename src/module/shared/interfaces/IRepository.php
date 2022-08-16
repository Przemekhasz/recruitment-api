<?php

namespace App\module\shared\interfaces;

interface IRepository
{
    public function create($entity);
    public function update($entity);
    public function delete($entity);
}