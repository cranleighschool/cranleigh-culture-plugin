<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 27/11/2018
 * Time: 08:44
 */

namespace FredBradley\CranleighCulturePlugin;


use GuzzleHttp\Client;

class OEmbed {

	public static $url;

	public static function getOembed(string $url) {

		$client = new Client();
		$res = $client->request('GET', 'https://issuu.com/oembed', [
			'query' => [
				'url' => $url."?e=5478439/54796210",
				'format' => 'json'
			]
		]);

		return json_decode($res->getBody());
	}


}
