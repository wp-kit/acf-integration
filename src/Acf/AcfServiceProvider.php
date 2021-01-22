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
						$this->app['config.factory']->get('acf.block_categories', []),
						$categories
					);
				}, 10, 2);
				
			}
			
			if( $this->app['config.factory']->get('acf.api.transform_post_objects_to_response', false) ) {
				
				action('rest_api_init', function () {
					
					filter('acf/format_value/type=post_object', 'transformPostObjectToResponse');
					filter('acf/format_value/type=relationship', function($value) {
						$value = is_array($value) ? $value : [];
						foreach($value as &$post) {
							$post = $this->transformPostObjectToResponse($post);
						}
						return $value;
					});
					
				});	
					
			}
		
			if( $this->app['config.factory']->get('acf.api.transform_blocks_for_api', false) ) {
				
				action('rest_response_parse_blocks', function ($blocks) {
					
					foreach($blocks as &$block) {
				
						if(strpos($block->blockName, 'acf/') === 0) {
				
							acf_setup_meta( json_decode(json_encode($block->attrs->data), true), $block->attrs->id, true );
					
							$id = $block->attrs->id;
					
							unset($block->attrs->name);
							unset($block->attrs->id);
							unset($block->attrs->data);
					
							$block->attrs = (object) array_merge((array) $block->attrs, get_fields($id));
						}
				
						if(!empty($block->innerBlocks) && is_array($block->innerBlocks)) {
							$block->innerBlocks = wp_rest_api_blocks_transform($block->innerBlocks);
						}
					}
			
					return array_values(array_filter($blocks, fn($block) => $block->blockName));
					
				});	
					
			}
		
			if( $this->app['config.factory']->get('acf.api.transform_numbers_to_floats', false) ) {
				
				filter('acf/format_value/type=number', function($value) { return (int) $value; });
					
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
        
		public function transformPostObjectToResponse($value) {

			if($value instanceof \WP_Post) {
				$response = (new \WP_REST_Posts_Controller($value->post_type))->prepare_item_for_response($value, ['context' => 'view']);
				$value = $response->data;
			}
			return $value;
			
		}
        
    }
