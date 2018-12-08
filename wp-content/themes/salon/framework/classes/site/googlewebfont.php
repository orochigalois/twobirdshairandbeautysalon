<?php

/**
 * Singleton class to manage Google Web Fonts embedding,
 * add the fonts with the weight and style
 * 
 */
class VP_Site_GoogleWebFont
{
	private $_fonts = array();

	private static $_instance = null;

	public static function instance()
	{
		if(self::$_instance == null)
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function add($name, $weights = 'normal', $styles = 'normal')
	{
		
		if(empty($name))
			return;

		$weights = (array) $weights;
		$styles  = (array) $styles;
		$name    = str_replace(' ', '+', $name);

		if(!isset($this->_fonts[$name]))
			$this->_fonts[$name] = array();

		foreach ($weights as $weight)
		{
			foreach ($styles as $style)
			{
				// set it to empty if style is equal to normal
				if($style === 'normal')
					$style = '';

				if($style != '')
					if($weight === 'normal') $weight = '';

				// skip if both are empty
				if($style === '' and $weight === '')
					continue;

				$couple = $weight . $style;

				if(!in_array($couple, $this->_fonts[$name]))
					$this->_fonts[$name][] = $couple;
			}
		}
	}

	public function register()
	{
		$links = $this->get_font_links();
		foreach ($links as $name => $link)
		{
			wp_register_style( $name, $link);
		}
	}

	public function enqueue()
	{
		$names = $this->get_names();
		foreach ($names as $name)
		{
			wp_enqueue_style( $name );
		}
	}

	public function register_and_enqueue()
	{
		$this->register();
		$this->enqueue();
	}

	public function get_font_links() /*edited by ozythemes, added font array and check*/
	{
		$links = array(); $non_google_fonts = array('Verdana, Geneva, sans-serif', 'Georgia, Times New Roman, Times, serif', 'Courier New, Courier, monospace', 'Arial, Helvetica, sans-serif', 'Tahoma, Geneva, sans-serif', 'Palatino Linotype, Book Antiqua, Palatino, serif', 'Trebuchet MS, Arial, Helvetica, sans-serif', 'Arial Black, Gadget, sans-serif', 'Times New Roman, Times, serif', 'Lucida Sans Unicode, Lucida Grande, sans-serif', 'MS Serif, New York', 'Lucida Console, Monaco, monospace', 'Comic Sans MS, cursive');

		// Add custom fonts too non google fonts arr		
		$ozy_fonts = get_posts(array('posts_per_page' => -1,'post_type' => 'ozy_fonts'));
		foreach ($ozy_fonts as $post) { array_push($non_google_fonts, str_replace(' ', ' ', '___' . $post->post_title)); }
		
		foreach ($this->_fonts as $name => $atts)
		{
			if(!in_array( str_replace('+',' ',$name), $non_google_fonts)) {
				$param = implode(',', $atts);
				$link  = "http://fonts.googleapis.com/css?family=$name" . ($param !== '' ? ":$param" : '');
				$links[$name] = $link;
			}
		}
		return $links;
	}

	public function get_fonts()
	{
		return $this->_fonts;
	}

	public function get_names()
	{
		return array_keys($this->_fonts);
	}

}

/**
 * EOF
 */