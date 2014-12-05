<?php namespace KalebKlein\KParser\Facades;

use Illuminate\Support\Facades\Facade;

class KParserFacade extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'kparser';
	}
}
