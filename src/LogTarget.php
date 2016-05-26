<?php
// vim: sw=4:ts=4:noet:sta:

namespace alexsalt\sentry;

use Yii;
use yii\log\Logger;
use yii\log\Target;

/**
 * sentry log target
 */
class LogTarget extends Target {
	/**
	 * @var string sentry component
	 */
	public $client = 'sentry';

	private $_client;

	public function init() {
		parent::init();
		$this->_client = Yii::$app->get($this->client)->client;
	}

	protected function getContextMessage() {
		return '';
	}

	/**
	 * override and filter out exceptions, cause they logged in errorHandler
	 */
    public static function filterMessages($messages, $levels = 0, $categories = [], $except = []) {
		foreach ($messages as $k => $message) {
			if ($message[0] instanceof \Exception) {
				unset($messages[$k]);
			}
		}
		return parent::filterMessages($messages, $levels, $categories, $except);
	}

	public function export() {
		foreach ($this->messages as $message) {
			list ($msg, $level, $category, $timestamp, $traces) = $message;

            $levelName = Logger::getLevelName($level);

			$payload = [
				'timestamp' => gmdate('Y-m-d\TH:i:s\Z', $timestamp),
				'level' => $levelName,
				'tags' => [ 'category' => $category ],
			];

			if (is_array($msg)) {
				$payload['message'] = isset($msg['msg']) ? $msg['msg'] : 'unknown message format';
				$payload['extra'] = isset($msg['data']) && is_array($msg['data']) ? $msg['data'] : null;
			} else {
				$payload['message'] = $msg;
			}

			$this->_client->capture($payload, $traces);
		}
	}
}
