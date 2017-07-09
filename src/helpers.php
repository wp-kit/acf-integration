<?php
	
	if( ! defined( 'DS' ) ) {
		
		define( 'DS', DIRECTORY_SEPARATOR );
		
	}
	
	if( ! function_exists('resources_path') ) {
		/**
	     * Gets the resources path
	     *
	     * @return string
	     */
	    function resources_path($path = '', $file = '')
	    {
		    if( function_exists('themosis_path') ) {
			    $path = themosis_path('theme' . ( $path ? '.' . $path : ''));
		    } else {
			    $path = get_stylesheet_directory() . DS . 'resources' . ( $path ? DS . $path : '' );
		    }
		    return $path . ltrim( ( $file ? DS . $file : '' ), DS );
	    }
	}
	
	if ( ! function_exists('get_asset') ) {
    
	    function get_asset( $file, $server_path = false ) {
		    
		    if( file_exists( get_stylesheet_directory() . DS . $dir . DS . $file ) ) {
		            
	            $path = $server_path ? get_stylesheet_directory() : get_stylesheet_directory_uri();
                
                return $path . DS . $dir . DS . $file;
                
            }
		    
	    }
	    
	}