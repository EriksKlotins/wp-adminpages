<?php



class MetaBox extends AdminPageContentContainer
{

	public $title = '';
	/**
	 * Vai laukus rādīt 2 kolonnās
	 * @var boolean
	 */
	public $twoColumns = false;
	public function __construct($title)
	{
		$this->title = $title;
	}

}