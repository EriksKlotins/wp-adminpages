<?php






/*
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 */
class testpage extends TopLevelPage
{
	public function pageContentHandler() 
	{ 
		echo 'bomba';
	}
}

class testSubPage extends SubPage
{
	public function pageContentHandler() 
	{ 
		echo 'vel viena bomba';
	}
}

class testSubPage2 extends SubPage
{
	public function pageContentHandler() 
	{ 
		echo $this->pageTitle($this->menu_title);
		echo $this->addUpdateNotice('šis ir notice');
		echo 'vel viena bomba BOMBA';
	}
}

class tab1 extends TabPage
{
	public function pageContentHandler() 
	{ 
		echo '<form class="form-wrap">';
		echo $this->sectionTitle('visādi lauki');
		echo $this->textField('lauks1', 'Mans lauks','','Apraksts');

		echo '</form>';
	}
}



class TestMetaBox extends MetaBox
{
	public function pageContentHandler() 
	{
		
		echo $this->textField('lauks1', 'Šis ir lauks', 'aa','Apraksts');
		echo $this->sectionTitle('Apakšsadala');
		echo $this->textField('lauks3', 'Šis ir cits lauks', 'aa','Apraksts');
		echo $this->linkButton('Links');
	}
	
}

class Test2MetaBox extends MetaBox
{
	public function pageContentHandler() 
	{
		echo 'aaa';
		echo $this->submitButton('Saglabāt');
	}
	
}


class Tabsarsarakstu extends TabPage
{
	public function pageContentHandler() 
	{
		$table = new UserTable();
		$table->renderList();
	}
	
}
//**********************
//


$a = new testpage('page_title','menu_title','edit_posts', 'menu_slug', 'tests', null, 10);


$a->addSubPage(new testSubPage('subpage_title','sub menu_title', 'edit_posts','sub_mnenu_slug'));
$a->addSubPage(new testSubPage2('subpage_title 2','sub menu_title 22', 'edit_posts','wer_Slyf'));


$tabbedPage = new SubPage('te būs tabi','te būs tabi', 'edit_posts','rfwefwgw');


$tabbedPage->addTabPage(new tab1('Parasts tabs', 'tab1','edit_posts'));
$tabbedPage->addTabPage(new Tabsarsarakstu('Tabs ar sarakstu', 'ttaefw','edit_posts'));
$mbpage = new TabPage('Vienādas kolonnas', 'tab32','edit_posts');



$mbpage->setMetaBoxLayout(MetaBoxLayout::EQUAL, [
	new TestMetaBox('kaste kaste'),
	new Test2MetaBox('kaste otra kaste'),
	new Test2MetaBox('trešā kaste')
	]);

$mbpage2 = new TabPage('Labā puse fixed', 'tab3232','edit_posts');
$mbpage2->setMetaBoxLayout(MetaBoxLayout::RIGHT_FIXED_LEFT_FLEX, [
	[new TestMetaBox('kaste kaste')],
	[new Test2MetaBox('kaste otra kaste'),
	new Test2MetaBox('trešā kaste')
	]]);


$mbpage3 = new TabPage('Kreisā puse fixed', 'tabew2','edit_posts');
$mbpage3->setMetaBoxLayout(MetaBoxLayout::LEFT_FIXED_RIGHT_FLEX, [
	[new TestMetaBox('kaste kaste')],
	[new Test2MetaBox('kaste otra kaste'),
	new Test2MetaBox('trešā kaste')
	]]);


$tabbedPage->addTabPage($mbpage);
$tabbedPage->addTabPage($mbpage2);
$tabbedPage->addTabPage($mbpage3);

$a->addSubPage($tabbedPage);