<?php

/*
	Uzģeneree tabulu, kas izskatās pec wp tabulas, 
	bet ar custom datiem
 */
abstract class WPRecordTable 
{
	/**
	 * Masīvs ar tabulas kolonnām,
	 * piemeram array('field'=> 'created_at', 'title'=>'Reģistrācijas datums', 'sort'=>true),
	 * field - lauka nosaukums
	 * title - virsraksts
	 * sort - vai laut kartot
	 * @var array
	 */
	protected $tableHeader = array();

	/**
	 * Cik rindiņas attelot lapā
	 * @var integer
	 */
	protected $itemsPerPage = 10;


	/**
	 * Masīvs ar bulk actions iespejam
	 * piemeram: array('key'=> 'dzest', 'title' => 'Dzest')
	 * key tiks padots GET action mainīgajā, iezīmetie posti, post[] masivā
	 * @var array
	 */
	 protected $bulkActions = array();
	// 	array('key'=>'key1', 'title'=>'Title 1'),
	// 	array('key'=> 'Title 1', 'title' => 'Title 2'));
	

	/**
	 * Masīvs ar filtriem (Tabiem), ko attelot virs tabulas
	 * piemeram array('title'=>'Visi', 'link'=>'#','count'=>23,'is-current'=>true),
	 * @var array
	 */
	protected $filters = array();
		// array('title'=>'Visi', 'link'=>'#','count'=>23),
		// array('title'=>'Daži', 'link'=>'/aa','count'=>234,'is-current'=>true));

	/**
	 * Lokalizācija
	 * @var array
	 */
	protected $labels =  array(
	    'name'               => 'Items',
	    'singular_name'      => 'Item',
	    'plural_name'		 => 'Items',
	    'name_pluralized'	 => 'Item(s)', // uzstādas automātiski atkarībā no ierakstu skaita
	    'add_new'            => 'Add New',
	    'add_new_item'       => 'Add New Item',
	    'edit_item'          => 'Edit Item',
	    'new_item'           => 'New Item',
	    'all_items'          => 'All Items',
	    'view_item'          => 'View Item',
	    'search_items'       => 'Search Items',
	    'menu_name'          => 'Items',
	    'apply'				 =>	'Apply',
	    'bulk_actions'		 => 'Bulk actions',
	    'of' 				 => 'of'
	  );

	/**
	 * Funkicja katras tabulas rūtiņas formatesanai,
	 * tiek izsaukta katras rindas, katram elementam
	 * @param  object $row   Rindas objekts, kādu to atgriež getItems()
	 * @param  string $field atribūta nosaukums, kas tiek drukāts
	 * @return string        Formateta vertība
	 */
	protected function prepareCellOutput($row, $field)
	{

		return stripslashes($row->$field);
	}

	/**
	 * Funkcija, kas tiek izmantota datu iegūšanai
	 * Te vajag izmantot Model::where()->orderBy()->get()
	 * Piemeram: 
	 * 	$params['s'] = '%'.$params['s'].'%';
	 *	return User::where('name','LIKE',$params['s'])->andWhere('account_no','IS NOT', null)
	 *		->orderBy($params['orderby'], $params['order'])
	 *		->limit($this->itemsPerPage,$this->itemsPerPage*($params['paged']-1))
	 *		->get();
	 * 
	 * @param  array  $params GET parametri, tabulas filtresanai un kartosanai
	 * @return array  Masīvs ar ierakstiem
	 */
	public abstract function getItems($params = array());
	
	
	/**
	 * funkcija, kas tiek izmantota, lai noteiktu ierakstu skaitu
	 * paginācijai, uc.
	 * Piemeram:
	 * 		$params['s'] = '%'.$params['s'].'%';
	 *	  	return User::where('name','LIKE',$params['s'])->andWhere('account_no','IS NOT', null)->count();
	 * @param  array  $params $params GET parametri, tabulas filtresanai un kartosanai
	 * @return int   ierakstu skaits
	 */
	public abstract function getCount($params = array());
	

	protected function arrayToParams($array)
	{
		return UrlHelper::arrayToParams($array);
	}

	private function prepareItems($items, $visibleFields)
	{
		
		$data = [];
		for($i=0;$i<count($items);$i++) 
		{
			$row = array();
			
			foreach ($visibleFields as $key) 
			{
				$row[] = array('field'=>$key, 'value'=>$this->prepareCellOutput($items[$i],$key));	
			}
			$data[] = array('fields'=>$row, 'rowid' => $items[$i]->ID,'uneven' => ($i % 2 == 0));
		}
		return $data;
	}

	/**
	 * Ģenere un izvada tabulu
	 * @param  string $template [description]
	 * @return [type]           [description]
	 */
	public function renderList($template = '_listView')
	{
		/*
			paskatamies ar kādiem parametriem ir atverts skats
		*/
		$defaultParameters = array(
			's'		=>null,
			'paged'	=> 1,
			'orderby' => '1',
			'order' =>'asc'
			);
	
		$parameters = array_merge($defaultParameters, $_GET);

		//die();
		/*
			Izrekinam visadas lietas
		*/
		$itemCount  = $this->getCount($parameters);
		$pageCount =  ceil($itemCount/ $this->itemsPerPage);

		/*
			Masīvs ar kolonnu virsrakstiem
		*/
		$tableHeader = $this->tableHeader;

		/*
			sakārtoajam datus tā, lai moustache tos var paņemt
		*/
		$visibleFields = array();
		for($i=0;$i<count($tableHeader);$i++)
		{
			if (isset($tableHeader[$i]['sort']))
			{
				
				if ($parameters['order'] == 'desc') $order = 'asc'; else $order = 'desc';
				$tableHeader[$i]['sort'] = array('order'=> $order);
				$tableHeader[$i]['link'] = $this->arrayToParams(array_merge($parameters, array('orderby'=>$tableHeader[$i]['field'], 'order'=>$order)));
				
			}
			$visibleFields[] = $tableHeader[$i]['field'];
		}
		$data = $this->prepareItems($this->getItems($parameters), $visibleFields);
		
		$tmpParams = [];

		foreach ($parameters as $key => $value) 
		{
			if (in_array($key, ['paged', 's','post'])) continue;
			$tmpParams[] = ['name'=>$key, 'value'=>$value];
		}
		
		$this->labels['name_pluralized'] = count($data) > 1 ? $this->labels['plural_name'] : $this->labels['singular_name'];

		$data = array(
			'items' => $data,
			'labels' =>$this->labels,
			'tableHeader' => $tableHeader,
			'count' => $itemCount,
			'search' => $parameters['s'],
			'pageCount'	=> $pageCount,
			'currentPage' => $parameters['paged'],
			'bulkActions' => $this->bulkActions,
			'has-bulkActions' => count ($this->bulkActions) > 0,
			'filters' => $this->filters,
			'has-filters' => count ($this->filters)>0,
			'links'	=> array(
				//'add_new' =>  $this->arrayToParams(array('page'=> $this->detailsPageSlug, 'id'=>'new')),
				'next_page'=> $parameters['paged']<$pageCount ? $this->arrayToParams(array_merge($parameters, array('paged'=>$parameters['paged']+1))) : '#',
				'prev_page' =>$parameters['paged']>1 ? $this->arrayToParams(array_merge($parameters, array('paged'=>$parameters['paged']-1))) : '#',
				'first_page'=>$parameters['paged']!=1 ? $this->arrayToParams(array_merge($parameters, array('paged'=>1))): '#',
				'last_page'=> $parameters['paged']!= $pageCount-1 ? $this->arrayToParams(array_merge($parameters, array('paged'=>$pageCount))): '#',
			),
			'pageSlug' => $parameters['page'],
			'parameters' => $tmpParams
		);
		//var_dump($data);



		$m = new Mustache( dirname(__FILE__).'/../templates');
    	echo $m->render($template,$data);
    

	}

}
