<?php namespace Lckamal\Navigation\Controller;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Messages;
use Orchestra\Support\Facades\Site;
use Lckamal\Navigation\Model\Navigation;
use Lckamal\Navigation\Model\NavigationGroup;
use Lckamal\Navigation\Validator\NavigationGroup as NavigationGroupValidator;

class NavigationsGroupController extends Controller
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
    public function __construct(NavigationGroupValidator $validator)
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

        $this->resource = 'navigation.groups';
        $this->beforeFilter('lckamal.navigation:create-navigation', array(
            'only' => array('create', 'store'),
        ));

        $this->beforeFilter('lckamal.navigation:update-navigation', array(
            'only' => array('edit', 'update'),
        ));

        $this->beforeFilter('lckamal.navigation:delete-navigation', array(
            'only' => array('delete', 'destroy'),
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
     * Write a navigation group.
     *
     * @return Response
     */
    public function create($group_id = 0)
    {
        Site::set('title', 'Write a Navigation Group');

        $navigationGroup         = new NavigationGroup;
        $navigationGroup->type   = 'navigation';

        return View::make('lckamal/navigation::group-editor', array(
            'navigationGroup' => $navigationGroup,
            'url'     => resources('navigation.groups'),
            'method'  => 'POST',
        ));
    }

    /**
     * Edit a navigation group.
     *
     * @return Response
     */
    public function edit($id = null)
    {
        Site::set('title', 'Write a Navigation Group');

        $navigationGroup = NavigationGroup::find($id);

        return View::make('lckamal/navigation::group-editor', array(
            'navigationGroup' => $navigationGroup,
            'url'     => resources("navigation.groups"),
            'method'  => 'PUT',
        ));
    }

    /**
     * Store a navigation.
     *
     * @return Response
     */
    protected function store()
    {
        $input         = Input::all();
        $validation    = $this->validator->on('create')->with($input);

        if ($validation->fails()) {
            return Redirect::to(resources("navigation.groups/create"))
                ->withInput()->withErrors($validation);
        }

        $navigation          = new NavigationGroup;
        $navigation->title = Input::get( 'title' );
        $navigation->abbrev = Input::get( 'abbrev' );

        $navigation->save();

        Messages::add('success', 'Navigation group has been created.');
        return Redirect::to(resources("navigation.groups/{$navigation->id}/edit"));
    }

    /**
     * Update a navigation.
     *
     * @access protected
     * @return Response
     */
    protected function update($id)
    {
        $input         = Input::all();
        $validation    = $this->validator->on('update')->with($input);

        if ($validation->fails()) {
            return Redirect::to(resources("navigations/{$input['navigation_group_id']}/create"))
                ->withInput()->withErrors($validation);
        }

        $navigation          = new NavigationGroup;
        $navigation->title = Input::get( 'title' );
        $navigation->abbrev = Input::get( 'abbrev' );

        $navigation->save();
        Messages::add('success', 'Navigation group has been updated.');
        return Redirect::to(resources("navigation.groups/{$navigation->id}/edit"));
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
        $content = NavigationGroup::findOrFail($id);

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

        Messages::add('success', 'Navigation group has been deleted.');

        return Redirect::to(resources('storycms.navigation.groups'));
    }
}
