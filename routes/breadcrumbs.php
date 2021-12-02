<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Users', route('users.index'));
});

Breadcrumbs::for('campaigns', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Campaigns', route('campaigns.index'));
});


Breadcrumbs::for('campaigns.edit', function (BreadcrumbTrail $trail, $campaign) {
    $trail->parent('campaigns');
    $trail->push($campaign->name, route('campaigns.edit', $campaign));
});

Breadcrumbs::for('campaigns.create', function (BreadcrumbTrail $trail) {
    $trail->parent('campaigns');
    $trail->push('Add Campaign', route('campaigns.create'));
});

Breadcrumbs::for('campaigns.view', function (BreadcrumbTrail $trail, $campaign) {
    $trail->parent('campaigns');
    $trail->push('View Campaign', route('campaigns.show', $campaign));
});

Breadcrumbs::for('campaigns.view.addmembers', function (BreadcrumbTrail $trail, $campaign) {
    $trail->parent('campaigns');
    $trail->push($campaign->name, route('campaigns.show', $campaign));
    $trail->push('Add Campaign Members', route('campaigns.addmembers', $campaign));
});

Breadcrumbs::for('campaigns.view.addclients', function (BreadcrumbTrail $trail, $campaign) {
    $trail->parent('campaigns');
    $trail->push($campaign->name, route('campaigns.show', $campaign));
    $trail->push('Add Campaign Clients', route('campaigns.addclients', $campaign));
});

Breadcrumbs::for('campaign.assets.view', function (BreadcrumbTrail $trail, $campaign, $user) {
    $trail->parent('campaigns');
    $trail->push($campaign->name, route('campaigns.show', $campaign));
    $trail->push("Member's assets", route('campaigns.addclients', $campaign));
});

Breadcrumbs::for('campaign.asset.show', function (BreadcrumbTrail $trail, $campaign, $user) {
    $trail->parent('campaigns');
    $trail->push($campaign->name, route('campaigns.show', $campaign));
    $trail->push("Review asset", route('campaigns.addclients', $campaign));
});

Breadcrumbs::for('member.asset.create', function (BreadcrumbTrail $trail, $campaign, $user) {
    $trail->parent('campaigns');
    $trail->push($campaign->name, route('campaigns.show', $campaign));
    $trail->push("Create asset", route('campaigns.addclients', $campaign));
});

Breadcrumbs::for('member.asset.edit', function (BreadcrumbTrail $trail, $campaign, $user) {
    $trail->parent('campaigns');
    $trail->push($campaign->name, route('campaigns.show', $campaign));
    $trail->push("Edit asset", route('campaigns.addclients', $campaign));
});


