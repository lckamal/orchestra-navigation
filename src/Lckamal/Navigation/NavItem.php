<?php namespace Lckamal\Navigation;

use Lckamal\Navigation\Model\Navigation;
use Lckamal\Navigation\Model\NavigationGroup;
use Orchestra\Story\Model\Content;

class NavItem {

	protected static $defaultOptions = array(
		'max_depth' => null,
		'nav_class' => '',
		'active_class' => 'active',
		'dropdown_class' => 'dropdown',
		'more_class' => 'dropdown-menu',
	);

	public function __construct()
	{
		parent::__construct();
	}

	public static function render($group = NULL, $options = array())
	{
		$navGroup = NavigationGroup::where('abbrev','=', $group)->first();

		if(!$navGroup) { return; }

		$navigations = Navigation::where('navigation_group_id','=',$navGroup->id)->get();

		$options['parent'] = 0;
		$options = array_merge(self::$defaultOptions, $options);
		$nav = '';
		if($navigations)
		{
			return self::buildNavigation($navigations, $options);
		}
	}

	protected static function buildNavigation($items, $options = array())
	{
		$hasChildren = false;
	    $outputHtml = '<ul class="'.$options['nav_class'].' %s">%s</ul>';
	    $childrenHtml = '';

	    foreach($items as $item)
	    {
	        if ($item->parent == $options['parent']) {
	            $hasChildren = true;
	            $childElem = self::buildNavigation($items, array_merge($options, array('parent' => $item->id, 'has_dropdown' => true)));
	            $dropdownClass = !empty($childElem) ? $options['dropdown_class'] : '';
	            
	            switch ($item->link_type) {
	            	case 'page':
	            		$url = url('#');
	            		$content = Content::find($item->page_id);
	            		if($content){
	            			list($type, $slug) = explode('/', $content->slug);
	            			$url = handles('orchestra/story::/'.$slug);
	            		}
	            		break;

	            	case 'uri':
	            		$url = url($item->uri);
	            		break;

	            	default:
	            		$url = $item->url;
	            		break;
	            }
	            $childrenHtml .= '<li class="'.$dropdownClass.'">';
	            $childrenHtml .= '<a href="'.$url.'" target="'.$item->target.'" class="'.$item->class.'">'.$item->title.'</a>';
	            $childrenHtml .= $childElem;
	            $childrenHtml .= '</li>';           
	        }
	    }

	    // Without children, we do not need the <ul> tag.
	    if (!$hasChildren) {
	        $outputHtml = '';
	    }

	    $ddmclass = isset($options['has_dropdown']) ? $options['more_class'] : '';
	    // Returns the HTML
	    return sprintf($outputHtml, $ddmclass, $childrenHtml);
	}

}