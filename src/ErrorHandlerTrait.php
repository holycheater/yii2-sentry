<?php
// vim: sw=4:ts=4:noet:sta:

namespace alexsalt\sentry;

use Yii;
use yii\base\ErrorException;

/**
 * trait for error handlers for logging exceptions
 */
trait ErrorHandlerTrait {

	/**
	 * @var string sentry client component name
	 */
	public $client = 'sentry';

	public function logException($exception) {
		parent::logException($exception);
		$this->logSentry($exception);
	}

	/**
	 * log exception to sentry
	 */
	public function logSentry($exception) {
		$sentry = Yii::$app->get($this->client)->client;
		$sentry->captureException($exception);
	}
}
