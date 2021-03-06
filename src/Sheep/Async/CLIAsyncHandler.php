<?php
/**
 * Copyright (c) 2017, 2018 KnownUnown
 *
 * This file is part of Sheep.
 *
 * Sheep is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Sheep is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);


namespace Sheep\Async;


use React\Promise\Deferred;
use React\Promise\Promise;

class CLIAsyncHandler implements AsyncHandler {
	use AsyncMixin;

	public function getURL(string $url, int $timeout = 10, array $extraHeaders = []): Promise {
		$deferred = new Deferred();

		$result = $this->docURL($url, CurlOptions::CURL_GET, $timeout, $extraHeaders, [], $error);
		if($error !== "") {
			$deferred->reject($error);
		} else {
			$deferred->resolve($result);
		}

		return $deferred->promise();
	}

	public function read(string $file): Promise {
		$deferred = new Deferred();

		$result = $this->readFile($file);
		if(!$result) {
			$deferred->reject();
		} else {
			$deferred->resolve($result);
		}

		return $deferred->promise();
	}

	public function write(string $file, string $data): Promise {
		$deferred = new Deferred();

		$result = $this->writeFile($file, $data);
		if(!$result) {
			$deferred->reject();
		} else {
			$deferred->resolve($result);
		}

		return $deferred->promise();
	}
}
