<?php

namespace App\Repositories;

use App\DTO\MySqlWatchDTO;
use App\Exceptions\​MySqlWatchNotFoundException;
use App\Exceptions\​MySqlRepositoryException;
use App\Intefaces\​MySqlWatchRepository;

class WatchRepository implements ​MySqlWatchRepository {

	protected $connection;

	public function __construct(\Nette\Database\Connection $db) {
		$this->connection = $db;
	}


	public function getWatchById(int $id): MySqlWatchDTO {
		try {
			$query = "SELECT id, price, description, title FROM `watch` WHERE id = ?;";
			$result = $this->connection->queryArgs($query, [$id])->fetch();
		} catch (\Nette\Database\ConnectionException $e) {
			throw new ​MySqlRepositoryException($e);
		} catch (\Nette\Database\DriverException $e) {
			throw new ​MySqlRepositoryException($e);
		}
		if (!$result) {
			throw new ​MySqlWatchNotFoundException('watch not found in database');
		}

		return new MySqlWatchDTO($result->id, $result->title, $result->price, $result->description);
	}
}
