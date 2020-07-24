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
					'page_title' => 'Options'
				]
		    ],
		    [
			    'type' => 'subpage',
			    'args' => [
				    'page_title' => 'Options 2',
				    'parent_slug' 	=> 'acf-options-options',
				]
			],
			[
			    'type' => 'subpage',
			    'args' => [
				    'page_title' => 'Options 3',
				    'parent_slug' 	=> 'acf-options-options',
				]
			]
	    ],
		
	    /*
	    |--------------------------------------------------------------------------
	    | ACF Blocks
	    |--------------------------------------------------------------------------
	    |
	    | Tell the Service Provider the ACF blocks required
	    |
	    */
	
	    'blocks' => [],
		
	    'block_categories' => [
		    [
				'slug' => 'rest-kit-example-blocks',
				'title' => 'Rest Kit Examples',
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
