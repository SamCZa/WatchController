<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;
use Contributte\ApiRouter\ApiRoute;

class RouterFactory {

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter() {
		$router = new RouteList;

		$router[] = new ApiRoute('/watch/<id>', 'Watch', [
			'methods' => ['GET']
		]);

		return $router;
	}
}
