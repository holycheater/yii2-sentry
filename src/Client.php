<?php
// vim: sw=4:ts=4:noet:sta:

namespace alexsalt\sentry;

use yii\base\Component;
use Raven_Client;

class Client extends Component {
	public $dsn;

	public $options = [ ];

	private $_client;

	public function init() {
		parent::init();
		$this->_client = new Raven_Client($this->dsn, $this->options);
	}

	public function getClient() {
		return $this->_client;
	}
}
