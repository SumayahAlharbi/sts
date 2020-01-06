<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', action('HomeController@index'));
});

// User Profile
Breadcrumbs::for('profile.show', function ($trail) {
  $trail->parent('home');
  $trail->push('Profile', route('profile.show',Auth::user()->id));
});

// User Profile
Breadcrumbs::for('user.profileSearch', function ($trail) {
  $trail->parent('profile.show');
  $trail->push('Search', route('user.profileSearch'));
});

//user Search
Breadcrumbs::for('user.userSearch', function ($trail) {
    $trail->parent('users.index');
    $trail->push('Search', route('user.userSearch'));
});

// ticket.index
Breadcrumbs::for('ticket.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Tickets', route('ticket.index'));
});

// ticket.search
Breadcrumbs::for('ticket.search', function ($trail) {
    $trail->parent('ticket.index');
    $trail->push('Search', route('ticket.search'));
});

// ticket.search
Breadcrumbs::for('ticket.statusFilter', function ($trail) {
    $trail->parent('ticket.index');
    $trail->push('Status Filter', route('ticket.statusFilter'));
});

// ticket.search
Breadcrumbs::for('ticket.groupFilter', function ($trail) {
    $trail->parent('ticket.index');
    $trail->push('Group Filter', route('ticket.groupFilter'));
});

// ticket.search
Breadcrumbs::for('ticket.todayTicket', function ($trail) {
    $trail->parent('ticket.index');
    $trail->push('Today Ticket', route('ticket.todayTicket'));
});

// ticket.late
Breadcrumbs::for('ticket.lateTicket', function ($trail) {
    $trail->parent('ticket.index');
    $trail->push('late Tickets', route('ticket.lateTicket'));
});

// ticket.create
Breadcrumbs::for('ticket.create', function ($trail) {
    $trail->parent('ticket.index');
    $trail->push('Create Ticket', route('ticket.create'));
});

// ticket.show
Breadcrumbs::for('ticket.show', function ($trail, $id) {
    $trail->parent('ticket.index');
    $ticket = app\Ticket::findOrFail($id);

    $trail->push($ticket->ticket_title, route('ticket.show', $ticket->id));
});

// ticket.edit
Breadcrumbs::for('ticket.edit', function ($trail, $id) {
    $trail->parent('ticket.index');
    $ticket = app\Ticket::findOrFail($id);

    $trail->push('Edit Ticket', route('ticket.edit', $ticket->id));
});

// ticket.trash
Breadcrumbs::for('ticket.trash', function ($trail) {
    $trail->parent('ticket.index');
    $trail->push('trash', route('ticket.trash'));
});

Breadcrumbs::macro('resource', function ($name, $title) {
    // Home > Blog
    Breadcrumbs::for("$name.index", function ($trail) use ($name, $title) {
        $trail->parent('home');
        $trail->push($title, route("$name.index"));
    });

    // Home > Blog > New
    Breadcrumbs::for("$name.create", function ($trail) use ($name) {
        $trail->parent("$name.index");
        $trail->push('New', route("$name.create"));
    });

    // Home > Blog > Post 123
    Breadcrumbs::for("$name.show", function ($trail, $model) use ($name) {
        $trail->parent("$name.index");
        $trail->push('show', route("$name.show", $model));
    });

    // Home > Blog > Post 123 > Edit
    Breadcrumbs::for("$name.edit", function ($trail, $model) use ($name) {
        $trail->parent("$name.index");
        $trail->push('Edit', route("$name.edit", $model));
    });
});

Breadcrumbs::resource('location', 'Location');
Breadcrumbs::resource('category','Category');
Breadcrumbs::resource('users','User');
Breadcrumbs::resource('status','Status');
Breadcrumbs::resource('group','Group');
Breadcrumbs::resource('regions','Region');
Breadcrumbs::resource('roles','Role');
Breadcrumbs::resource('permissions','Permission');
Breadcrumbs::resource('releases','Release');
Breadcrumbs::resource('Exports','Export');

// ticket.index
Breadcrumbs::for('activity.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Activity', route('activity.index'));
});
