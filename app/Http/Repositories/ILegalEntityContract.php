<?php

namespace App\Http\Repositories;

interface ILegalEntityContract 
{
	public function store($data);

	public function update($data, $id);

	public function getAllEntities($data);

	public function getEntityWithHistory($data);
}