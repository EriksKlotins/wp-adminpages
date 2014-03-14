<?php

class SubPage extends AdminPageContentContainer
{
	public $page_title;
	public $menu_title;
	public $capability;
	public $menu_slug;
	public $function;
	public $hidden;





	/**
	 * Uztaisa apakšlapu
	 * @param [type]  $page_title Lapas virsraksts (jāizdrukā pašam)
	 * @param [type]  $menu_title Menu virsraksts
	 * @param [type]  $capability WP Capability (edit_posts darbojas ok)
	 * @param [type]  $menu_slug  Menu id, unikāls
	 * @param boolean $hidden     ja true, tad šī lapa neparādīsies izvelnee, bet bus pieejama ar linku
	 */
	public function __construct( $page_title, $menu_title, $capability, $menu_slug, $hidden = false)
	{
		$this->hidden = $hidden;
		$this->page_title = $page_title;
		$this->menu_title = $menu_title;
		$this->capability = $capability;
		$this->menu_slug = $menu_slug;
		$this->function = array(&$this,'pageContentHandler');
	}


	

	


	public function pageContentHandler()
	{
		parent::pageContentHandler();
		//var_dump('I am a lonely content handler..');
	}


	
}
