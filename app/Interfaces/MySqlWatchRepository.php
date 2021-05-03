<?php

namespace App\Intefaces;

use App\DTO\MySqlWatchDTO;

interface ​MySqlWatchRepository {
    /**
     * @param int $id
     *
     *
     * @throws MySqlWatchNotFoundException Is thrown when the watch could
     * not be found in a mysql
     * database, eg. watch with the
     * associated id does not exist.
     *
     * @throws MySqlRepositoryException May be thrown on a fatal error,
     * such as connection
     * to a database failed.
     */
    // public function getWatchById(int $id) : \App\DTO\MySqlWatchDTO;
    public function getWatchById(int $id): MySqlWatchDTO;
}
