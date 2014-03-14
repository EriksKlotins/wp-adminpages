<?php  


class AdminPageContentContainer extends WPAdminHTMLFactory
{

	protected $tabPages = array();
	protected $metaBoxes = array();
	//-------
	public $metaBoxlayout = null;


	/**
	 * Mainīgie, kas nav jāpadod tālāk urlī
	 * @var array
	 */
	protected $unset = array();


	public function pageContentHandler() 
	{
		if (count($this->tabPages) > 0)
		{
			 $this->pageContentTabs();
			 exit;
		}
		if (count($this->metaBoxes) > 0)
		{
			$this->pageContentMetaBoxes();
			exit;
		}
		echo $this->pageTitle($this->menu_title);
		echo $this->addErrorNotice('Content handler is not set');
		var_dump($this);
	}

	public function pageContentTabs()
	{
		if (count($this->tabPages) == 0)
		{
			$this->addErrorNotice('No tabs defined');
			return;
		}

		//echo $this->pageTitle($this->menu_title);
		echo $this->pageTabs($this->tabPages);
		foreach ($this->tabPages as $tab) 
		{
			if ($tab->active)
			{
				$tab->pageContentHandler();
				break;
			}
		}
	}

	public function addMetaBox($metaBox)
	{
		$this->metaBoxes[] = $metaBox;
		
	//	$this->function = [&$this, 'pageContentMetaBoxes'];
	//	var_dump($this);
	}
	
	/**
	 * Pievieno lapai tabu
	 * @param object $tabPage TabPage instance
	 */
	public function addTabPage($tabPage)
	{
		//var_dump($this);
		//$this->function = [&$this, 'pageContentTabs'];
		$tabPage->url = UrlHelper::arrayToParams(array_merge($_GET,['page'=>$this->menu_slug, 'tab'=>$tabPage->menu_slug]), $this->unset);
		$tabPage->active = false;
		$this->tabPages[] = $tabPage;

		if (isset($_GET['page']) && $_GET['page'] == $this->menu_slug)
		{
			if (isset($_GET['tab']))
			{
				if ($_GET['tab'] == $tabPage->menu_slug)
				{
					$this->tabPages[count($this->tabPages)-1]->active = true;
				}
			}
			else
			{
				$this->tabPages[0]->active = true;
			}
		}


		$active_tab = isset($_GET['tab']) ? $_GET['tab'] : null;
		$active_page = isset($_GET['page']) ? $_GET['page'] : null;
	
		$tabPage->active = ( $active_tab== $tabPage->menu_slug && $active_page == $this->menu_slug);
	}

	public function pageContentMetaBoxes()
	{
		switch ($this->metaBoxlayout) 
		{
			case MetaBoxLayout::EQUAL:
				$this->equalMetaboxes($this->metaBoxes);
				break;
			case MetaBoxLayout::LEFT_FIXED_RIGHT_FLEX:
				$this->leftFixedMetaboxes($this->metaBoxes);
				break;

			case MetaBoxLayout::RIGHT_FIXED_LEFT_FLEX:
				$this->rightFixedMetaboxes($this->metaBoxes);
			break;
			
			default:
				# code...
				break;
		}
	}

	public function addUpdateNotice($text)
	{
		return $this->addNotice($text, 'updated');
	}

	public function addErrorNotice($text)
	{
		return $this->addNotice($text, 'error');
	}

	public function setMetaBoxLayout($layout, $boxes)
	{
		$this->metaBoxlayout = $layout;
		$this->metaBoxes = $boxes;
	}


}