<?php namespace Lckamal\Navigation\Controller;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\Site;
use Lckamal\Navigation\Model\NavigationGroup;

class HomeController extends Controller
{
    /**
     * Define filters for current controller.
     *
     * @return void
     */
    protected function setupFilters()
    {
        //
    }

    /**
     * Show Dashboard.
     *
     * @return Response
     */
    public function getIndex()
    {
        $acl = Acl::make('lckamal/navigation');

        if ($acl->can('create navigation') or $acl->can('manage navigation')) {
            return $this->write();
        }

        return View::make('lckamal/navigation::home');
    }

    /**
     * Write a post.
     *
     * @return Response
     */
    protected function write()
    {
        Site::set('title', 'Write a Navigation');

        $contents = NavigationGroup::all();
        $type     = 'navigation';

        Site::set('title', 'List of Navigations');

        return View::make('lckamal/navigation::home', compact('contents', 'type'));
    }
}
