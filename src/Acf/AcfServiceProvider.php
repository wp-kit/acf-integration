<?php
    
    namespace WPKit\Integrations\Acf;
    
    use WPKit\Integrations\Integration;
    use Exception;

	class AcfServiceProvider extends Integration {
		
		/**
	     * Boot the service provider.
	     *
	     * @return void
	     */
		public function boot() {
			
			$this->publishes([
				__DIR__.'/../../config/acf.config.php' => config_path('acf.config.php')
			], 'config');
		
		}
    	
    	/**
	     * Start the integration.
	     *
	     * @return void
	     */
    	public function startIntegration() {
		
		if( defined( 'WP_CLI' ) && WP_CLI ) {
				
				return false;
				
			}
		
		if( function_exists('acf_register_block_type') ) {
			
			$defaults = [
				'category' => 'rest-kit-example-blocks',
				'render_callback' => [$this, 'renderBlock']
			];
	        	
	        	foreach($this->app['config.factory']->get('acf.blocks', []) as $block) {
				
				$block = array_merge($defaults, $block);
				
				acf_register_block_type($block);
				
			}
			
			filter( 'block_categories', function($categories, $post) {
				return array_merge(
					$categories,
					$this->app['config.factory']->get('acf.block_categories', [])
				);
			}, 10, 2);
			
		}
        	
        	if( function_exists('acf_add_options_page') ) {
	        	
	        	foreach($this->app['config.factory']->get('acf.pages', []) as $page) {
		        	
		        	if( empty( $page['type'] ) || empty( $page['args'] ) ) {
			        	
			        	throw new Exception( 'ACF page is misconfigured and has missing $type or $args attributes' );
			        	
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
								
				add_filter('acf/settings/save_json', function($path) {
				   
				    // return
				    return $this->app['config.factory']->get('acf.json_path', resources_path('acf'));
					
				} );
				
				add_filter('acf/settings/load_json',  function($paths) {
				
					// update path
				    $paths[] = $this->app['config.factory']->get('acf.json_path', resources_path('acf'));
				   
				    // return
				    return $paths;
					
				} );
				
			}
            
        }
		
		/**
	     * Output block HTML
	     *
	     * @return string
	     */
		public function renderBlock($block, $inner_blocks) {
			
			echo view('blocks.' . $block['name'], compact('block', 'inner_blocks'));
			
		}
        
       
        
    }
