<?php

namespace Dubhunter\Libphonenumber;

use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;

class Format {
	const DEFAULT_REGION = 'US';

	/**
	 * @param string|PhoneNumber $number
	 * @param string $defaultRegion
	 * @return PhoneNumber
	 */
	protected static function getNumberProto($number, $defaultRegion = self::DEFAULT_REGION) {
		if ($number instanceof PhoneNumber) {
			return $number;
		}

		$util = PhoneNumberUtil::getInstance();
		$region = strpos($number, '+') === false ? $defaultRegion : 'ZZ';
		return $util->parse($number, $region);
	}

	/**
	 * @param string|PhoneNumber $number
	 * @param string $defaultRegion
	 * @return string
	 */
	public static function e164($number, $defaultRegion = self::DEFAULT_REGION) {
		$util = PhoneNumberUtil::getInstance();
		$proto = self::getNumberProto($number, $defaultRegion);
		return $util->format($proto, PhoneNumberFormat::E164);
	}

	/**
	 * @param string|PhoneNumber $number
	 * @param string $defaultRegion
	 * @return string
	 */
	public static function national($number, $defaultRegion = self::DEFAULT_REGION) {
		$util = PhoneNumberUtil::getInstance();
		$proto = self::getNumberProto($number, $defaultRegion);
		return $util->format($proto, PhoneNumberFormat::NATIONAL);
	}

	/**
	 * @param string|PhoneNumber $number
	 * @param string $defaultRegion
	 * @return string
	 */
	public static function international($number, $defaultRegion = self::DEFAULT_REGION) {
		$util = PhoneNumberUtil::getInstance();
		$proto = self::getNumberProto($number, $defaultRegion);
		return $util->format($proto, PhoneNumberFormat::INTERNATIONAL);
	}

	/**
	 * @param string|PhoneNumber $number
	 * @param string $region
	 * @return string
	 */
	public static function localized($number, $region = self::DEFAULT_REGION) {
		$util = PhoneNumberUtil::getInstance();
		$proto = self::getNumberProto($number, $region);
		return $util->getRegionCodeForNumber($proto) == $region ? self::national($proto) : self::international($proto);
	}
}
