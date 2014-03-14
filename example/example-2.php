<?php
class ClientLoansTable extends WPRecordTable
{
	protected $tableHeader = [
	 			//array('field'=> 'ID', 'title'=>'ID'),
				array('field'=> 'created_at', 'title'=>'Datums', 'sort'=>true),
				array('field'=> 'purpose', 	'title'=>'Merķis', 'sort'=>true),
				array('field'=> 'term', 'title'=>'Termiņš', 'sort'=>true),
				array('field'=> 'amount', 'title'=>'Summa', 'sort'=>true)
	 	];
	public function getItems($params = array())
	{
		$params['s'] = '%'.$params['s'].'%';
		$id = (int) $_GET['id'];
		return Loan::where('user_id','=',$id)
			->orderBy($params['orderby'], $params['order'])
			->limit($this->itemsPerPage,$this->itemsPerPage*($params['paged']-1))
			->get();
	}

	public function getCount($params = array())
	{
		
		$params['s'] = '%'.$params['s'].'%';
		$id = (int) $_GET['id'];
		return Loan::where('user_id','=',$id)->count();
	}

	protected function prepareCellOutput($row, $field)
	{
			switch ($field) {
			case 'created_at':
				return date_format( $row->$field, 'd. m. Y.');
				break;
			case 'name':
				return stripslashes($row->name.' '.$row->surname);
				break;
			case 'options':
				return sprintf('<a class="row-title" href="%s">Skatīt</a>',$this->arrayToParams(['page'=>'p2p_loan_details', 'loan_id'=>$row->loan_id]));
				break;
			default:
				return stripslashes($row->$field);
				break;
		}
	}
}