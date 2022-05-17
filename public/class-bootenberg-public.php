<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/iwasthesword
 * @since      1.0.0
 *
 * @package    Bootenberg
 * @subpackage Bootenberg/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Bootenberg
 * @subpackage Bootenberg/public
 * @author     iwasthesword <cinzadiscos@gmail.com>
 */
class Bootenberg_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bootenberg_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bootenberg_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bootenberg-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bootenberg_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bootenberg_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bootenberg-public.js', array( 'jquery' ), $this->version, false );

	}

	public function override_blocks() {
		function bs_block_wrapper( $block_content, $block ) {
			if ( $block['blockName'] === 'core/columns' ) {
				$c = "";
				if (array_key_exists("className",$block["attrs"])) {
					$c = $block["attrs"]["className"];
				}
				$block_content = "<div class='row ".$c."'>";
				
				for ($i=0;$i<count($block["innerBlocks"]);$i++) {
					$block_content .= bs_block_wrapper($block["innerBlocks"][$i]["innerHTML"],$block["innerBlocks"][$i]);
				}
				$block_content .= "</div>";
				$content = $block_content;
				return $content;
			} 
			if ( $block['blockName'] === 'core/column' ) {
				$c = "";
				$s = "";
				$a = "";
				if (array_key_exists("className",$block["attrs"])) {
					$c = $block["attrs"]["className"];
				}
				if (array_key_exists("width",$block["attrs"])) {
					$s .= "flex-basis: ".$block["attrs"]["width"];
					$a = "-auto";
				}
			  
				$block_content = "<div class='col".$a." ".$c."' style='".$s."'>";
				
				for ($i=0;$i<count($block["innerBlocks"]);$i++) {
				  $block_content .= bs_block_wrapper($block["innerBlocks"][$i]["innerHTML"],$block["innerBlocks"][$i]);
				}
				$block_content .= "</div>";
				$content = $block_content;
				return $content;
			} 
			return $block_content;
		}
		add_filter( 'render_block', 'bs_block_wrapper', 10, 2 );
	}

}
