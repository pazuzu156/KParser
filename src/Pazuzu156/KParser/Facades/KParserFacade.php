<?php namespace Pazuzu156\KParser\Facades;

use Illuminate\Support\Facades\Facade;

class KParserFacade extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'kparser';
	}
}
