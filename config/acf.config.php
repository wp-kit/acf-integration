<?php
	
	// In theme/resources/config/acf.config.php

	return [
	
	    /*
	    |--------------------------------------------------------------------------
	    | ACF Options Args
	    |--------------------------------------------------------------------------
	    |
	    | Tell the Service Provider which pages to register in the admin area
	    |
	    */
	
	    'pages' => [
		    [
			    'type' => 'page',
			    'args' => [
					// see https://www.advancedcustomfields.com/resources/acf_add_options_page/
				]
		    ],
		    [
			    'type' => 'subpage',
			    'args' => [
				    // see https://www.advancedcustomfields.com/resources/acf_add_options_sub_page/
				]
			]
	    ],
	
	    /*
	    |--------------------------------------------------------------------------
	    | ACF JSON Path
	    |--------------------------------------------------------------------------
	    |
	    | Tell the Server Provider where to find JSON files to save and load
	    | configurations from. By default the below function loads from:
	    |
	    | ~/theme/resources/acf/
	    |
	    */
	
	    'json_path' => resources_path('acf')
	
	];