<?php namespace Lckamal\Navigation\Controller;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Orchestra\Support\Facades\Messages;
use Orchestra\Support\Facades\Site;
use Lckamal\Navigation\Model\Navigation;
use Lckamal\Navigation\Model\NavigationGroup;
use Orchestra\Story\Model\Content;
use Lckamal\Navigation\Validator\Navigation as NavigationValidator;

class NavigationsController extends Controller
{
    /**
     * Current Resource.
     *
     * @var string
     */
    protected $resource;

    /**
     * Validation instance.
     *
     * @var object
     */
    protected $validator = null;

    /**
     * Content CRUD Controller.
     *
     * @param \Orchestra\Story\Validation\Content  $validator
     */
    public function __construct(NavigationValidator $validator)
    {
        //parent::__construct();

        $this->validator = $validator;
    }

    /**
     * Define filters for current controller.
     *
     * @return void
     */
    public function setupFilters()
    {
        parent::setupFilters();

        $this->resource = 'navigation.links';
        $this->beforeFilter('lckamal.navigation:create-navigation', array(
            'only' => array('create', 'store'),
        ));

        $this->beforeFilter('lckamal.navigation:update-navigation', array(
            'only' => array('edit', 'update'),
        ));

        $this->beforeFilter('lckamal.navigation:delete-navigation', array(
            'only' => array('delete', 'destroy'),
        ));

        $this->beforeFilter('lckamal.navigation:creategroup-navigation', array(
            'only' => array('creategroup', 'storegroup'),
        ));

        $this->beforeFilter('lckamal.navigation:updategroup-navigation', array(
            'only' => array('editgroup', 'updategroup'),
        ));

        $this->beforeFilter('lckamal.navigation:deletegroup-navigation', array(
            'only' => array('deletegroup', 'destroygroup'),
        ));
    }

    /**
     * List all the navigations.
     *
     * @return Response
     */
    public function index()
    {
        $contents = NavigationGroup::all();
        $type     = 'navigation';

        Site::set('title', 'List of Navigations');

        return View::make('lckamal/navigation::index', compact('contents', 'type'));
    }

    /**
     * Write a navigation.
     *
     * @return Response
     */
    public function create($group_id = 0)
    {
        Site::set('title', 'Write a Navigation');

        $navigation         = new Navigation;
        $navigation->type   = 'navigation';
        $navigations = Navigation::all();
        $pageList = Content::lists('title', 'id');
        $navList = Navigation::where('navigation_group_id', '=', $group_id)->lists('title', 'id');
        $navigationGroupList = NavigationGroup::lists('title', 'id');

        return View::make('lckamal/navigation::editor', array(
            'navigation' => $navigation,
            'url'     => resources('navigation.links'),
            'method'  => 'POST',
            'pageList' => $pageList,
            'navList' => $navList,
            'navigations' => $navigations,
            'navigationGroupList' => $navigationGroupList,
            'navigation_group_id' => $group_id
        ));
    }

    /**
     * Edit a navigation.
     *
     * @return Response
     */
    public function edit($id = null)
    {
        Site::set('title', 'Write a Navigation');

        $navigation = Navigation::find($id);
        $pageList = Content::lists('title', 'id');
        $navList = Navigation::where('navigation_group_id', '=', $navigation->navigation_group_id)->lists('title', 'id');
        $navigationGroupList = NavigationGroup::lists('title', 'id');

        return View::make('lckamal/navigation::editor', array(
            'navigation' => $navigation,
            'url'     => resources("navigation.links/{$navigation->id}"),
            'method'  => 'PUT',
            'pageList' => $pageList,
            'navList' => $navList,
            'navigationGroupList' => $navigationGroupList,
            'navigation_group_id' => $navigation->navigation_group_id
        ));
    }

    /**
     * Store a navigation.
     *
     * @return Response
     */
    protected function store()
    {
        $validation = $this->validate();
        if ($validation->fails()) {
            return Redirect::to(resources("navigation.links/".Input::get('navigation_group_id')."/create"))
                ->withInput()->withErrors($validation);
        }

        $navigation          = new Navigation;
        $navigation->title = Input::get( 'title' );
        $navigation->link_type = Input::get( 'link_type' );
        $navigation->parent = (int)Input::get( 'parent' );
        $navigation->page_id = Input::get( 'page_id' );
        $navigation->url = Input::get( 'url' );
        $navigation->uri = Input::get( 'uri' );
        $navigation->navigation_group_id = Input::get( 'navigation_group_id' );
        $navigation->position = (int)Input::get( 'position' );
        $navigation->target = Input::get( 'target' );
        $navigation->class = Input::get( 'class' );

        $navigation->save();

        Messages::add('success', 'Navigation has been created.');
        return Redirect::to(resources("navigation.links/{$navigation->id}/edit"));
    }

    /**
     * Update a navigation.
     *
     * @access protected
     * @return Response
     */
    protected function update($id)
    {
        $validation = $this->validate();
        if ($validation->fails()) {
            return Redirect::to(resources("navigation.links/".$id."/edit"))
                ->withInput()->withErrors($validation);
        }

        $navigation = Navigation::find($id);
        $navigation->title = Input::get( 'title' );
        $navigation->link_type = Input::get( 'link_type' );
        $navigation->parent = (int)Input::get( 'parent' );
        $navigation->page_id = Input::get( 'page_id' );
        $navigation->url = Input::get( 'url' );
        $navigation->uri = Input::get( 'uri' );
        $navigation->navigation_group_id = Input::get( 'navigation_group_id' );
        $navigation->position = (int)Input::get( 'position' );
        $navigation->target = Input::get( 'target' );
        $navigation->class = Input::get( 'class' );

        $navigation->save();
        Messages::add('success', 'Navigation has been updated.');
        return Redirect::to(resources("navigation.links/{$navigation->id}/edit"));
    }

    /**
     * Delete a content.
     *
     * @return Response
     */
    public function delete($id = null)
    {
        return $this->destroy($id);
    }

    /**
     * Delete a content.
     *
     * @return Response
     */
    public function destroy($id)
    {
        $content = Navigation::findOrFail($id);

        return call_user_func(array($this, 'destroyCallback'), $content);
    }
    /**
     * Delete a navigation.
     *
     * @access protected
     * @return Response
     */
    protected function destroyCallback($content)
    {
        $content->delete();

        Messages::add('success', 'Navigation has been deleted.');

        return Redirect::to(resources('navigation.links'));
    }

    protected function validate()
    {
        $input = Input::all();

        $rules = array(
            'title' => 'required|min:3',
            'link_type' => 'required',
            'target' => 'required',
            'url' => 'url'
        );
        if($link_type = Input::get('link_type'))
        {
            $link_field = ($link_type == 'page') ? 'page_id' : $link_type;
            $rules[$link_field] = 'required';
        }
        return $validation = Validator::make($input, $rules);
    }
}
