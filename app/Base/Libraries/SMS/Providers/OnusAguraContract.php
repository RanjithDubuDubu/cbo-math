<?php

namespace App\Base\Libraries\SMS\Providers;

interface OnusAguraContract {
	/**
	 * Send the SMS.
	 *
	 * @param array $numbers
	 * @param string $message
	 * @param int $type
	 * @return bool
	 * @throws \App\Base\Libraries\SMS\Exceptions\SMSFailException
	 * @throws \App\Base\Libraries\SMS\Exceptions\SMSInsufficientCreditsException
	 */ 
	public function send($number,$message,$type);
}
