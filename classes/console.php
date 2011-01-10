<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Main CLI class
 */
class Console
{
	const ERROR		= 0;
	const SUCCESS	= 1;
	const HEADER	= 2;

	/**
	 * Main cli instance
	 * @var console
	 */
	public static $instance;

	protected static $_stdout;

	/**
	 *
	 *
	 * @return Console
	 */
	public static function instance()
	{
		if ( ! Console::$instance)
		{
			// Command line access ONLY
			if ( ! Kohana::$is_cli) {
				return FALSE;
			}

			self::$instance = new Console;

			self::$_stdout = fopen('php://stdout', 'w');
		}

		return Console::$instance;
	}

	public function __destruct()
	{
		fclose(self::$_stdout);
		exit;
	}

	public function out($line = PHP_EOL)
	{
		fwrite(self::$_stdout, $line);
		fflush(self::$_stdout);
	}

	public function out_line($delimiter = '=')
	{
		$this->out(str_pad("", 80, $delimiter) . PHP_EOL);
	}

	public function action_help()
	{
		foreach (Kohana_Core::include_paths() as $module) {
			 var_dump($module);
		}
	}


	/**
	 * Format output text
	 *
	 * @param string $text
	 * @param int $type self::ERROR || self::SUCCESS || self::HEADER
	 * @return string
	 */
	public static function format($text, $type)
	{
		switch ($type) {
			case self::ERROR :
				$text = "\033[01;38;5;160m" . $text . "\033[39m";
				break;

			case self::SUCCESS :
				//@FIXME
				break;

			case self::HEADER :
				$text = str_pad(" [ " . $text . " ] ", 80, '=', STR_PAD_BOTH) . PHP_EOL;
				break;
		}

		return $text;
	}
}