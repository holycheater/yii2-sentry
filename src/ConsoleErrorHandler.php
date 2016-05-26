<?php
// vim: sw=4:ts=4:noet:sta:

namespace alexsalt\sentry;

class ConsoleErrorHandler extends \yii\console\ErrorHandler {
	use ErrorHandlerTrait;
}
