<?php

 

class TabPage extends SubPage
{
	public $url = '#';
	public $active = false;

	public function __construct($title, $slug, $capability)
	{
		parent::__construct($title, $title,$capability ,$slug);
	}
}