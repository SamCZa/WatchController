<?php

namespace App\Controllers;

use App\DTO\MySqlWatchDTO;
use Nette\Caching\Cache;
use Nette\Caching\Storage;
use App\Repositories\WatchRepository;
use App\Parsers\WatchParser;

class WatchController {

    protected $conn;

    /** @var Storage */
    protected $storage;

    /** @var Cache */
    private $cache;

    /** @var WatchRepository */
    private $watchRepository;

    /** @var WatchParser */
    private $watchParser;

    /** @var boolean */
    protected $useDB;

    public function __construct(\Nette\Database\Connection $database, \Nette\Caching\Storage $storage, Cache $cache, WatchRepository $watchRepository, WatchParser $watchParser, $useDB = true) {
        $this->conn = $database;
        $this->storage = $storage;
        $this->useDB = $useDB;
        $this->cache = $cache;
        $this->watchRepository = $watchRepository;
        $this->watchParser = $watchParser;
    }
    public function getByIdAction($id) {
        $res = $this->cache->load($id);

        if ($res) {
            return $res;
        }

        if ($this->useDB) {
            $res = $this->watchRepository->getWatchById($id);
        } else {
            $xmlResult = $this->watchParser->​loadByIdFromXml($id);
            if (!$xmlResult) {
                return null;
            }
            $res = new MySqlWatchDTO($xmlResult['id'], $xmlResult['title'], $xmlResult['price'], $xmlResult['description']);
        }

        $this->cache->save($id, $res);
        return $res;
    }
}
