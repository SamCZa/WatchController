<?php

namespace App\Parsers;

use App\Exceptions\​XmlLoaderException;
use App\Intefaces\​XmlWatchLoader;
use SimpleXMLElement;

class WatchParser implements ​XmlWatchLoader {

	/**
	 * @var string
	 */
	private $xmlUrl;

	public function __construct($xmlUrl) {
		$this->xmlUrl = $xmlUrl;
	}

	public function ​loadByIdFromXml(string $watchIdentification): ?array {
		try {
			$previousSetting = libxml_use_internal_errors(true);
			$file = file_get_contents($this->xmlUrl);
			$xml = new SimpleXMLElement($file);
			foreach ($xml->watch as $watch) {
				if ((string) $watch->id === $watchIdentification) {

					return [
						'id' => (int) $watch->id,
						'title' => (string) $watch->title,
						'price' => (int) $watch->price,
						'description' => (string) $watch->desc
					];
				}
			}
			return null;
		} catch (\Exception $e) {
			throw new ​XmlLoaderException($e);
		} finally {
			libxml_use_internal_errors($previousSetting);
		}
	}
}
