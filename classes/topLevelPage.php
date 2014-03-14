<?php



class TopLevelPage extends AdminPageContentContainer
{
	protected $page_title;
	protected $menu_title;
	protected $capability;
	protected $menu_slug;
	protected $function;
	protected $icon_url;
	protected $position;
	//
	//
	protected $subPages = array();

	
	public function __construct($page_title, $menu_title, $capability, $menu_slug, $icon_url, $position )
	{
		//	var_dump(func_get_args());
		$this->page_title = $page_title;
		$this->menu_title = $menu_title;
		$this->capability = $capability;
		$this->menu_slug = $menu_slug;
		$this->function = null;
		$this->icon_url = $icon_url;
		$this->position = $position;
	//	var_dump($this->page_title,$this->icon_url);
		add_action( 'admin_menu', array(&$this, 'admin_menu_handler') );
	}

	public function admin_menu_handler()
	{
		//var_dump($this);
		add_menu_page( $this->page_title, $this->menu_title, $this->capability, $this->menu_slug, [$this, 'pageContentHandler'], $this->icon_url, $this->position );
		
		for($i=0;$i<count($this->subPages);$i++)
		{
			$parent_menu_slug = $this->subPages[$i]->hidden ? null : $this->menu_slug;
			add_submenu_page( $parent_menu_slug, $this->subPages[$i]->page_title, $this->subPages[$i]->menu_title, $this->subPages[$i]->capability, $this->subPages[$i]->menu_slug, $this->subPages[$i]->function);
	
		}
	}

	
	public function addSubPage($subPage)
	{

		$this->subPages[] = $subPage;
	}
}
