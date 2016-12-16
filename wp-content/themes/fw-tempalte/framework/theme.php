<?php
/**
 * @package WordPress
 * @subpackage Theme
 * @since theme 1.0
 */

if( !class_exists( 'Fw_template' ) ) {

	class Fw_template
	{

		protected $func_args = array();
		protected $incs_args = array();
		protected $libs = array();
		protected $vc_args = array();
		protected $shortcode_args = array();

		function __construct()
		{
			$this->contant();
			//spl_autoload_register( array( $this, 'autoLoadIncs' ) );

			$this->setFuncs_Args();
			$this->setIncs_Args();
		}

		public function init()
		{

			$this->register_theme_activation_hook('Fw_template', array($this, 'themeActiveSetup'));

			//add_action( 'init', array( $this, 'wooProductSize' ) );

			$this->init_Incs_Args();

			add_action('after_setup_theme', array($this, 'c_setup'));

			$this->register_theme_deactivation_hook('Fw_template', array($this, 'themeDeactive'));

			add_action('wp_enqueue_scripts', array($this, 'frontendScripts'));

			add_action('admin_enqueue_scripts', array($this, 'backendScripts'));

			add_action('init', array($this, 'register_image_size'));

			add_action( 'init', array($this,'create_post_type_custom') );


			if (is_admin()) {
//				new Fw_template_MetaBox();
			}

			$this->vc_custom();

		}
		public function  create_post_type_custom(){

		}

		private function checkConditions($conditions = '')
		{
			$return = false;
			switch ($conditions) {
				case 'frontend':
					$return = !is_admin() ? true : false;
					break;
				case 'backend':
					$return = is_admin() ? true : false;
					break;
				default:
					$return = true;
			}
			return $return;
		}

		private function init_Incs_Args()
		{
			foreach ($this->libs as $k => $incs) {
				$conditions = $this->checkConditions($k);
				if ($conditions) {
					/*$incs['args'] = explode( ',', $incs['args'] );*/
					foreach ($incs['args'] as $inc) {
						include_once $incs['path'] . trim($inc) . ".php";
					}
				}

			}

			foreach ($this->incs_args as $k => $incs) {
				$conditions = $this->checkConditions($k);
				if ($conditions) {
					/*$incs['args'] = explode( ',', $incs['args'] );*/
					foreach ($incs['args'] as $inc) {
						include_once $incs['path'] . trim($inc) . ".php";
					}
				}

			}

			foreach ($this->func_args as $k => $incs) {
				$conditions = $this->checkConditions($k);
				if ($conditions) {
					/*$incs['args'] = explode( ',', $incs['args'] );*/
					foreach ($incs['args'] as $inc) {
						include_once $incs['path'] . trim($inc) . ".php";
					}
				}

			}

		}

		private function setFuncs_Args()
		{
			$this->func_args = array(
				'backend' => array(
					'path' => THEME_BACKEND_FUNC,
					'args' => array(),
				),
				'' => array(
					'path' => THEME_FRAMEWORK_FUNC,
					'args' => array(),
				),
			);
		}

		private function setIncs_Args()
		{
			$this->incs_args = array(
				'all' => array(
					'path' => THEME_FRAMEWORK_INCS,
					'args' => array()
				),
				'backend' => array(
					'path' => THEME_BACKEND_INCS,
					'args' => array(),
				)
			);

			$this->libs = array(
				'all' => array(
					'path' => THEME_FRONTEND . 'libs/',
					'args' => array()
				)
			);
		}

		public function dequeue_style()
		{
			if (wp_style_is('yith-wcwl-font-awesome', 'enqueued')) {
				wp_dequeue_style('yith-wcwl-font-awesome');
				wp_deregister_style('yith-wcwl-font-awesome');
			}
		}

		public function frontendScripts()
		{
			global $Fw_template_datas, $detect;

			if (!Fw_template::checkPlugin('redux-framework/redux-framework.php') || !Fw_template::checkPlugin('nexthemes-plugin/nexthemes-plugin.php')) {
				//wp_enqueue_style('Fw_template-fonts', Fw_template_fonts_url(), array(), null);
			}

			wp_enqueue_style('Fw_template-fonts', Fw_template_fonts_url(), array(), null);

			wp_enqueue_style('bootstrap.min', THEME_CSS_URI . 'bootstrap.min.css');
			/*wp_enqueue_style( 'bootstrap-theme.min', THEME_CSS_URI . 'bootstrap-theme.min.css' );*/

			wp_enqueue_style('owl.carousel', THEME_CSS_URI . 'owl.carousel.css');
			wp_enqueue_style('owl.theme.default', THEME_CSS_URI . 'owl.theme.default.css');

			wp_enqueue_style('font-awesome.min', THEME_CSS_URI . 'font-awesome.min.css', false, '4.4.0');

			add_action('wp_print_styles', array($this, 'dequeue_style'));

			wp_enqueue_style('animate', THEME_CSS_URI . 'animate.css', false, false);
			wp_enqueue_style('Fw_template-icons', THEME_CSS_URI . 'Fw_template-icons.css', false, '1.0.0');

			/*Visual composer plugin*/
			wp_enqueue_style('js_composer_front');

			wp_enqueue_style('Fw_template-style', get_template_directory_uri() . '/style.css');

			do_action('Fw_template_child_style');

			if (!empty($Fw_template_datas['css_editor'])) {
				wp_add_inline_style('Fw_template-style', $Fw_template_datas['css_editor']);
			}


			wp_enqueue_script('Fw_template-libs-js', THEME_JS_URI . 'Fw_template-libs.min.js', false, false, true);

			if (!$detect->isMobile()) {
				if (!isset($Fw_template_datas['smooth-scroll']) || absint($Fw_template_datas['smooth-scroll']) == 1) {
					wp_enqueue_script('smoothScroll.js', THEME_JS_URI . 'smoothScroll.js', array('jquery'), '1.3.9', true);
				}
			}

			wp_register_script('Fw_template-main-js', THEME_JS_URI . 'Fw_template-main.js', false, false, true);

			$drop_drag_js = (isset($Fw_template_datas['main-right-toolbar']) && absint($Fw_template_datas['main-right-toolbar']) == 0) ||
			(isset($Fw_template_datas['shop-dropdrag-cart']) && absint($Fw_template_datas['shop-dropdrag-cart']) == 0) ? 0 : 1;
			$Fw_template_data = array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'wpnonce' => wp_create_nonce('_nth_ajax_nonce_56672'),
				'loading_icon' => admin_url('images/spinner.gif'),
				'isDropDrag' => $drop_drag_js,
				'templ_url' => esc_url(get_template_directory_uri()),
				'rtl' => is_rtl() ? 1 : 0
			);

			wp_localize_script('Fw_template-main-js', 'Fw_template_data', $Fw_template_data);

			wp_enqueue_script('Fw_template-main-js');

			if (is_singular() && comments_open() && get_option('thread_comments')) {
				wp_enqueue_script('comment-reply');
			}
		}

		public function backendScripts($hook_suffix)
		{

		}

		public function contant()
		{
			$this->define('OPS_THEME', 'Fw_template_datas');
			$this->define('THEME_NAME', 'Fw_template');
			$this->define('THEME_DIR', get_template_directory() . '/');
			$this->define('THEME_URI', get_template_directory_uri() . '/');

			$this->define('THEME_IMG_URI', THEME_URI . 'images/');
			$this->define('THEME_CSS_URI', THEME_URI . 'css/');
			$this->define('THEME_JS_URI', THEME_URI . 'js/');

			$this->define('THEME_FRAMEWORK', THEME_DIR . 'framework/');
			$this->define('THEME_FRAMEWORK_INCS', THEME_FRAMEWORK . 'incs/');
			$this->define('THEME_FRAMEWORK_FUNC', THEME_FRAMEWORK . 'functions/');

			$this->define('THEME_FRONTEND', THEME_FRAMEWORK . 'frontend/');
			$this->define('THEME_FE_LIBS', THEME_FRONTEND . 'libs/');
			$this->define('THEME_FE_IMG', THEME_FRONTEND . 'images/');
			$this->define('THEME_FE_CSS', THEME_FRONTEND . 'css/');
			$this->define('THEME_FE_JS', THEME_FRONTEND . 'js/');

			$this->define('THEME_FRAMEWORK_URI', THEME_URI . 'framework/');
			$this->define('THEME_FRONTEND_URI', THEME_FRAMEWORK_URI . 'frontend/');
			$this->define('THEME_FE_CSS_URI', THEME_FRONTEND_URI . 'css/');
			$this->define('THEME_FE_JS_URI', THEME_FRONTEND_URI . 'js/');
			$this->define('THEME_FE_IMG_URI', THEME_FRONTEND_URI . 'images/');

			$this->define('THEME_BACKEND', THEME_FRAMEWORK . 'backend/');
			$this->define('THEME_BACKEND_CSS', THEME_BACKEND . 'css/');
			$this->define('THEME_BACKEND_INCS', THEME_BACKEND . 'incs/');
			$this->define('THEME_BACKEND_FUNC', THEME_BACKEND . 'functions/');

			$this->define('THEME_BACKEND_URI', THEME_FRAMEWORK_URI . 'backend/');
			$this->define('THEME_BACKEND_CSS_URI', THEME_BACKEND_URI . 'css/');
			$this->define('THEME_BACKEND_JS_URI', THEME_BACKEND_URI . 'js/');


			//backend
			define('Fw_template_MEGA_MENU_K', 'Fw_template_MEGA');
		}

		private function define($name, $value)
		{
			if (!defined($name)) {
				define($name, $value);
			}
		}

		public function theme_slug_render_title()
		{
			?>
			<title><?php wp_title('|', true, 'right'); ?></title>
			<?php
		}

		public function c_setup()
		{
			global $content_width;

			// This theme styles the visual editor with editor-style.css to match the theme style.
			add_editor_style();

			//title tag
			add_theme_support('title-tag');

			// This theme supports a variety of post formats.
			if (!function_exists('_wp_render_title_tag')) :
				add_action('wp_head', array($this, 'theme_slug_render_title'));
			endif;

			add_theme_support('post-formats', array('video', 'audio', 'gallery'));

			//support post thumbnails.
			add_theme_support('post-thumbnails');
			set_post_thumbnail_size(825, 510, true);

			//setup default background
			add_theme_support('custom-background', array(
				"default-color" => 'ffffff',
				"default-image" => '',
			));
			//automatic feed RSS link to header.
			add_theme_support('automatic-feed-links');
			//Support woocommerce plugin
			add_theme_support('woocommerce');

			if (!isset($content_width)) {
				$content_width = 1170;
			}

			load_theme_textdomain('Fw_template', THEME_DIR . 'languages');

			//menu location.
			register_nav_menu('primary-menu', esc_html__('Primary Menu', 'Fw_template'));
			register_nav_menu('vertical-menu', esc_html__('Vertical Menu', 'Fw_template'));
			register_nav_menu('mobile-menu', esc_html__('Mobile Menu', 'Fw_template'));

			global $detect;
//			$detect = new Mobile_Detect;
		}

		public function wooProductSize()
		{
			update_option('shop_catalog_image_size', array(
				'width' => '280',
				'height' => '315',
				'crop' => 1
			));

			update_option('shop_single_image_size', array(
				'width' => '480',
				'height' => '540',
				'crop' => 1
			));

			update_option('shop_thumbnail_image_size', array(
				'width' => '70',
				'height' => '78',
				'crop' => 1
			));
		}

		public function register_theme_activation_hook($code, $_call)
		{
			$optionKey = "theme_is_activated_" . $code;
			if (!get_option($optionKey)) {
				call_user_func($_call);
				update_option($optionKey, 1);
			}
		}

		public function themeActiveSetup()
		{
			$this->wooProductSize();
		}

		public function register_image_size()
		{
			if (function_exists('add_image_size')) {
				global $Fw_template_datas;

				$blog_thumbnail_width = isset($Fw_template_datas["blog-thumbnail-size-width"]) ?
					$Fw_template_datas["blog-thumbnail-size-width"] : 870;
				$blog_thumbnail_height = isset($Fw_template_datas["blog-thumbnail-size-height"]) ?
					$Fw_template_datas["blog-thumbnail-size-height"] : 696;
				$blog_list_thumbnail_width = isset($Fw_template_datas["blog-thumbnail-list-size-width"]) ?
					$Fw_template_datas["blog-thumbnail-list-size-width"] : 300;
				$blog_list_thumbnail_height = isset($Fw_template_datas["blog-thumbnail-list-size-height"]) ?
					$Fw_template_datas["blog-thumbnail-list-size-height"] : 240;
				$blog_widget_thumbnail_width = isset($Fw_template_datas["blog-thumbnail-widget-size-width"]) ?
					$Fw_template_datas["blog-thumbnail-widget-size-width"] : 100;
				$blog_widget_thumbnail_height = isset($Fw_template_datas["blog-thumbnail-widget-size-height"]) ?
					$Fw_template_datas["blog-thumbnail-widget-size-height"] : 67;
				$blog_single_width = isset($Fw_template_datas["blog-single-size-width"]) ?
					$Fw_template_datas["blog-single-size-width"] : 1170;
				$blog_single_height = isset($Fw_template_datas["blog-single-size-height"]) ?
					$Fw_template_datas["blog-single-size-height"] : 1000;
				$shop_subcat_width = isset($Fw_template_datas["shop-subcat-size-width"]) ?
					$Fw_template_datas["shop-subcat-size-width"] : 100;
				$shop_subcat_height = isset($Fw_template_datas["shop-subcat-size-height"]) ?
					$Fw_template_datas["shop-subcat-size-height"] : 100;

				add_image_size('Fw_template_mega_menu_icon', 30, 30, true);
				add_image_size('Fw_template_mini_product_img', 50, 50, true);
				add_image_size('Fw_template_blog_thumb', $blog_thumbnail_width, $blog_thumbnail_height, true);
				add_image_size('Fw_template_blog_thumb_list', $blog_list_thumbnail_width, $blog_list_thumbnail_height, true);
				add_image_size('Fw_template_blog_thumb_grid', 575, 383, true);
				add_image_size('Fw_template_blog_thumb_widget', $blog_widget_thumbnail_width, $blog_widget_thumbnail_height, true);
				add_image_size('Fw_template_blog_single', $blog_single_width, $blog_single_height, true);
				add_image_size('Fw_template_shop_subcat', $shop_subcat_width, $shop_subcat_height, true);
				add_image_size('Fw_template_shop_subcat_large', 370, 400, true);
				add_image_size('Fw_template_product_super_deal', 370, 200, true);

				if(class_exists('WeDevs_Dokan')) {
					$store_list_size = isset($Fw_template_datas["store-list-thumbnail"]) ?
						$Fw_template_datas["store-list-thumbnail"] : array('width' => 300, 'height' => 175);

					add_image_size('Fw_template_dokan_stores_thumbnail', $store_list_size['width'], $store_list_size['height'], true);
				}
			}
		}

		public function register_theme_deactivation_hook($code, $_call)
		{
			// store function in code specific global
			$GLOBALS["wp_register_theme_deactivation_hook_function" . $code] = $_call;

			// create a runtime function which will delete the option set while activation of this theme and will call deactivation function provided in $function
			$fn = create_function('$theme', ' call_user_func($GLOBALS["wp_register_theme_deactivation_hook_function' . $code . '"]); delete_option("theme_is_activated_' . $code . '");');

			add_action("switch_theme", $fn);
		}

		public function Fw_template_vcSetAsTheme()
		{
			vc_set_as_theme();
		}

		protected function vc_custom()
		{

			if (class_exists('Vc_Manager')) {
				add_action('vc_before_init', array($this, 'Fw_template_vcSetAsTheme'));

				vc_set_shortcodes_templates_dir(THEME_BACKEND_INCS . 'vc_customs/vc_temeplates');
			}

			if (class_exists('WPBakeryVisualComposerAbstract')) {
				include_once THEME_BACKEND_INCS . 'vc_customs/class.autocomplete.query.php';
				include_once THEME_BACKEND_INCS . 'vc_customs/class.autocomplete.php';
				include_once THEME_BACKEND_INCS . 'vc_customs/pagrams.php';

				add_action('vc_build_admin_page', array($this, 'load_vc_map_custom'));
				add_action('vc_load_shortcode', array($this, 'load_vc_map_custom'));
			}
		}

		public function load_vc_map_custom()
		{
			include_once THEME_BACKEND_INCS . 'vc_customs/vc_maps/vc_new_param.php';
			include_once THEME_BACKEND_INCS . 'vc_customs/vc_maps/vc_elements.php';
			include_once THEME_BACKEND_INCS . 'vc_customs/vc_maps/vc_woocommerce.php';
		}

		public static function checkPlugin($path = '')
		{
			if (strlen($path) == 0) return false;
			$_actived = apply_filters('active_plugins', get_option('active_plugins'));
			if (in_array(trim($path), $_actived)) return true;
			else return false;
		}

		public static function Fw_template_getOption($slug = 'page_options', $datas = array())
		{
			$options = unserialize(get_post_meta(get_the_id(), 'Fw_template_' . $slug, true));

			if (isset($options) && is_array($options)) {
				foreach ($options as $key => $value) {
					if (isset($value) && strlen($value) > 0) $datas[$key] = $value;
				}
			}
			return $datas;
		}

		public static function get_owlResponsive($options = array())
		{
			$column = $options['items'];

			$resp = array(
				0 => array(
					'items' => round($column * (479 / 1200)),
					'loop' => false
				),
				480 => array(
					'items' => round($column * (768 / 1200)),
					'loop' => false
				),
				769 => array(
					'items' => round($column * (980 / 1200)),
					'loop' => false
				),
				981 => array(
					'items' => round($column * (1199 / 1200)),
					'loop' => false
				),
			);
			if (isset($options['responsive']) && is_array($options['responsive'])) {
				foreach ($options['responsive'] as $k => $arg) {
					$resp[$k] = $arg;
				}
			}
			$options['responsive'] = $resp;

			return $options;
		}

		public function themeDeactive()
		{

		}
	}
}
 
?>
