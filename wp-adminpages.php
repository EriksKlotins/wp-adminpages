<?php

	require dirname(__FILE__).'/classes/dashIcon.php';
	require dirname(__FILE__).'/classes/fontAwesome.php';
	require dirname(__FILE__).'/classes/recordTableFilter.php';
	require dirname(__FILE__).'/classes/recordTable.php';
	require dirname(__FILE__).'/classes/htmlFactory.php';
	require dirname(__FILE__).'/classes/contentContainer.php';
	require dirname(__FILE__).'/classes/metaBoxLayout.php';
	require dirname(__FILE__).'/classes/topLevelPage.php';
	require dirname(__FILE__).'/classes/subPage.php';
	require dirname(__FILE__).'/classes/tabPage.php';
	require dirname(__FILE__).'/classes/metaBox.php';



	

	class WPAdminPages
	{
		public function __construct()
		{
			add_action( 'admin_enqueue_scripts', [&$this,'theme_admin_scripts'] );
		}
		public function theme_admin_scripts()
		{
			wp_enqueue_style( 'a', content_url() . '/mu-plugins/wp-adminpages/assets/css/columns.css' );
			wp_enqueue_style( 'b', content_url() . '/mu-plugins/wp-adminpages/assets/css/user.css' );
			wp_enqueue_style( 'font-awesome', content_url() . '/mu-plugins/wp-adminpages/assets/css/font-awesome.min.css' );
		}
	}
	

	new WPAdminPages();