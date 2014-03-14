<?php 

class WPAdminHTMLFactory
{

	public function pageTitle($title)
	{
		return sprintf('<h2>%s</h2>', $title);
	}

	public function sectionTitle($title)
	{
		return sprintf('<h3>%s</h3>', $title);
	}

	public function addNotice($text, $class)
	{
		return sprintf('<div class="%s" id=""><p>%s</p></div>',$class, $text);
	}

	public function submitButton($title, $name = 'submit')
	{
		return sprintf('<p class="submit"><input type="submit" name="%s" value="%s" class="button button-primary"><br class="clear"></p>',
			$name, $title);
	}
	public function table($headerArr, $bodyArr)
	{
		$header = '';
		$body = '';
		foreach ($headerArr as $value) 
		{
			$header .= sprintf('<th>%s</th>', $value);
		}
		$header = '<tr>'.$header.'</tr>';
		foreach ($bodyArr as $row) 
		{
			$r = '';
			foreach ($headerArr as $key=>$cell) 
			{
				$r .= sprintf('<td>%s</td>', $row->$key);
			}
			$body .= '<tr>'.$r.'</tr>';
		}


		echo sprintf('<table class="widefat"><thead>%s</thead><tbody>%s</tbody></table>', $header, $body); 

	}

	/**
	 * uhfiwhiewhfiewurhfw
	 * @param  [type] $title [apraks]
	 * @param  string $url   [description]
	 * @param  DashIcon $icon Icon on button
	 * @return [type]        [description]
	 */
	public function linkButton($title, $url = '#', $icon = null)
	{
		if ($icon === null)
		{
			return sprintf('<a href="%s" class="button">%s</a>', 
				$url, 
				$title);
			
		}
		else
		{
			return sprintf('<a href="%s" class="button"><div class="dashicons %s"></div>&nbsp;%s</a>', 
				$url, 
				$icon,
				$title);
		}
			
		

		
	}


	public function leftFixedMetaboxes($metaBoxes)
	{
		echo '
				<div class="wrap metabox-holder">
				<div id="nav-menus-frame">
			    <div id="menu-settings-column">';
			    for ($i=0;$i<count($metaBoxes[0]);$i++)
		    	{
		    		
		    		$this->createMetabox($metaBoxes[0][$i]); 
		    	}
		echo 	'</div>
			 
			    <div id="menu-management-liquid">';
				for ($i=0;$i<count($metaBoxes[1]);$i++)
		    	{
		    		
		    		$this->createMetabox($metaBoxes[1][$i]); 
		    	}
		echo 	'</div> </div></div>';

	}

	public function rightFixedMetaboxes($metaBoxes)
	{ 
		echo'<div class="wrap">
		<div id="poststuff" class="metabox-holder has-right-sidebar">
		    <div class="inner-sidebar">';
		    	for ($i=0;$i<count($metaBoxes[0]);$i++)
		    	{
		    		$this->createMetabox($metaBoxes[0][$i]); 
		    	}
		        
		    echo '</div> <div id="post-body">
		        <div id="post-body-content">
		            <div id="titlediv"></div>
		            <div id="postdivrich" class="postarea"></div>';
		            for ($i=0;$i<count($metaBoxes[1]);$i++)
			    	{
			    		$this->createMetabox($metaBoxes[1][$i]); 
			    	}
		 
		        echo '</div></div><br class="clear">
		</div></div>';
	}

	private function createMetabox($metaBox)
	{
		echo '<div id="normal-sortables" class="ui-sortable meta-box-sortables">';			
		echo sprintf('<div class="postbox" id="%s">', '');
		echo '<div class="handlediv" title="Click to toggle"><br></div>';
		echo sprintf('
			<h3 class="hndle"><span>%s</span></h3>
			<div class="inside">',$metaBox->title);
		echo sprintf('<form method="post" class="form-wrap %s" enctype="multipart/form-data">',
			$metaBox->twoColumns ? 'two-columns' :'');
			$metaBox->pageContentHandler();
		echo '<br class="clear">';
		echo '</form>';
		 echo '</div>';
		 echo '</div>';
		 echo '</div>';
	}
	public function equalMetaboxes($metaBoxes)
	{

		echo '
		
		<div class="wrap">
		<div id="dashboard-widgets-wrap">
		    <div id="dashboard-widgets" class="metabox-holder">';
		        
		           
		                
		                for($i=0;$i<count($metaBoxes);$i++)
						{

							
							echo sprintf('<div class="postbox-container" id="postbox-container-%d" >', $i+1);
							$this->createMetabox($metaBoxes[$i]);
							 echo '</div>';
			
						}
		       
		        echo '
		   
		     </div>
		     </div>
		</div>';
	}
	
	public function pageTabs($tabs = array())
	{
		$result = '';
		
		foreach ($tabs as $tab) 
		{
			$result .= sprintf('<a href="%s" class="nav-tab %s">%s</a>',
				$tab->url,
				$tab->active ? 'nav-tab-active' : '',
				$tab->menu_title
				);
		}
		

		return sprintf('<h2 class="nav-tab-wrapper">%s</h2>',$result);
	}


	public function nameAndValue($name, $value)
	{
		return sprintf('<p>%s: &nbsp;<strong>%s</strong></p>', $name, $value);
	}
	public function textAreaField($name, $title, $value = '', $description = '', $required = false)
	{
		return sprintf('<div class="form-field"><label for="%s">%s</label><textarea aria-required="%s" name="%s" id="%s">%s</textarea><p class="description">%s</p></div>',
				$name,
				$title,
				$required ? 'true' : 'false',
				$name,
				$name,
				$value,
				
				
				$description
			);
		
	}
	public function numberField($name, $title, $value = 0, $description = '', $required = false, $min = 0, $max =  99)
	{
		return sprintf('<div class="form-field"><label for="%s">%s</label><input type="number" aria-required="%s"  value="%s" min="%d" max="%d" name="%s" id="%s"><p class="description">%s</p></div>',
				$name,
				$title,
				$required ? 'true' : 'false',
				
				$value,
				$min,
				$max, 
				$name,
				$name,
				$description
			);
		
	}
	public function selectField($name, $title, $value = null, $description = '', $values = array())
	{
		$options = '';

		foreach ($values as $key => $item) 
		{
			$options .= sprintf('<option value="%s" %s>%s</option>', 
				$key, 
				$key == $value ? 'selected="selected"' : '',
				$item);
		}
		return sprintf('<div class="form-field"><label for="%s">%s</label><select name="%s" id="%s">%s</select><p class="description">%s</p></div>',
			$name,
			$title,
			$name,
			$name,
			$options,
			$description);


	}

	public function textField($name, $title, $value = '', $description = '', $required = false, $size = 9999)
	{
		return sprintf('<div class="form-field"><label for="%s">%s</label><input type="text" aria-required="%s" size="%d" value="%s" name="%s" id="%s"><p class="description">%s</p></div>',
				$name,
				$title,
				$required ? 'true' : 'false',
				$size,
				$value,
				$name,
				$name,
				$description
			);
		
	}

	/**
	 * Tukšums ar ko aizpildīt formu..
	 * @return [type] [description]
	 */
	public function emptySpace()
	{
		return '<div class="form-field" style="height:60px;"></div>';
	}
	public function fileField($name, $title, $value = '')
	{
		return sprintf('<div class="form-field"><label for="%s">%s</label><input type="file" name="%s"/></div>',
			$name,
			$title,
			$name
		);
	}

}
