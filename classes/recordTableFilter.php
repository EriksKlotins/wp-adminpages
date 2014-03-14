<?php



class WPRecordTableFilter
{
	public $title;
	public $url;
	public $count;
	public $current = false;

	public function __construct($title, $link = '#', $count = 0)
	{
		$this->title = $title;
		$this->link = $link;
		$this->count = (string) $count;
		//$this->current = strpos($url, )
	}
}