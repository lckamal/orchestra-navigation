@section('lckamal/navigation::primary_menu')

<?php

use Illuminate\Support\Facades\HTML;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Fluent;
use Orchestra\Support\Facades\App; ?>

<ul class="nav navbar-nav">
	<li class="{{ Request::is('*resources/navigation.*') ? 'active' : '' }}">
		<a href="{{ resources('navigation.groups') }}">Navigation</a>
	</li>
</ul>
@stop

<?php

$navbar = new Fluent(array(
	'id'    => 'navigation',
	'title' => 'Navigation',
	'url'   => resources('navigation'),
	'menu'  => View::yieldContent('lckamal/navigation::primary_menu'),
)); ?>

@decorator('navbar', $navbar)

<br>
