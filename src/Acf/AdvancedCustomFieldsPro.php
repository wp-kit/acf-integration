<?php
    
    namespace WPKit\Integrations\Acf;
    
    use WPKit\Integrations\IntegrationServiceProvider;
    use Exception;

	class AcfServiceProvider extends IntegrationServiceProvider {
    	
    	public function startIntegration() {
        	
        	if( function_exists('acf_add_options_page') ) {
	        	
	        	foreach($this->app['config.factory']->get('acf.pages', []) as $page) {
		        	
		        	if( empty( $page['type'] ) || empty( $page['args'] ) ) {
			        	
			        	throw new Exception( 'ACF page is misconfigured and has missing $type or $args attributes' );
			        	
		        	}
		        	
		        	if( ! empty( $page['args']['icon_url'] ) ) {
		        	
			        	$icon = &$page['args']['icon_url'];
			        	
			        	$icon = ! filter_var($icon, FILTER_VALIDATE_URL) ? get_asset( $icon ) : null;

					}
					
		        	switch( $page['type'] ) {
			        	
			        	case 'subpage' :
			        	
			        		if( empty( $page['args']['parent_slug'] ) ) {
				        		
				        		throw new Exception( 'ACF page is misconfigured and has missing $parent_slug attribute' );
				        		
			        		}
 			        	
			        		acf_add_options_sub_page( $page['args'] );
			        		
			        	break;
			        	
			        	default :
			        	
			        		acf_add_options_page( $page['args'] );
			        		
			        	break;
			        	
		        	}
		        	
	        	}
								
				add_filter('acf/settings/save_json', function($path) use($settings) {
				   
				    // return
				    return $this->app['config.factory']->get('acf.json_path', resources_path('acf'));
					
				} );
				
				add_filter('acf/settings/load_json',  function($paths) use($settings) {
				
					// update path
				    $paths[] = $this->app['config.factory']->get('acf.json_path', resources_path('acf'));
				   
				    // return
				    return $paths;
					
				} );
				
			}
            
        }
        
       
        
    }