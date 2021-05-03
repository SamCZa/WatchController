<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Controllers\WatchController;
use App\Exceptions\​MySqlRepositoryException;
use App\Exceptions\​MySqlWatchNotFoundException;
use App\Exceptions\​XmlLoaderException;
use Nette;

final class WatchPresenter extends Nette\Application\UI\Presenter {
    public $controller;

    public function __construct(WatchController $controler) {
        $this->controller = $controler;
    }

    public function startup() {
        parent::startup();
        $this->autoCanonicalize = false;
    }

    public function actionRead($id) {

        if (!ctype_digit($id)) {
            $this->sendJsonError(Nette\Http\Response::S400_BAD_REQUEST, 'Request must contain numeric value only');
        }
        try {
            $value = $this->controller->getByIdAction($id);
            if (!$value) {
                $this->sendJsonError(Nette\Http\Response::S404_NOT_FOUND, 'Watch not found in XML file');
            }
            $this->sendJson(['identification' => $value->id, 'title' => $value->title, 'price' => $value->price, 'description' => $value->description]);
        } catch (​MySqlWatchNotFoundException $e) {
            $this->sendJsonError(Nette\Http\Response::S404_NOT_FOUND, 'Watch not found in MySql');
        } catch (​MySqlRepositoryException $e) {
            $this->sendJsonError(Nette\Http\Response::S500_INTERNAL_SERVER_ERROR, 'Mysql error has occured');
        } catch (​XmlLoaderException $e) {
            $this->sendJsonError(Nette\Http\Response::S500_INTERNAL_SERVER_ERROR, 'Parsing of XML failed');
        }
    }

    private function sendJsonError($errorCode, $message) {
        $httpResponse = $this->getHttpResponse();
        $httpResponse->setCode($errorCode);
        $response = new \Nette\Application\Responses\JsonResponse(['error' => $message]);
        $this->sendResponse($response);
    }
}
