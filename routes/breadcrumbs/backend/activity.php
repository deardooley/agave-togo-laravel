<?php

Breadcrumbs::for('activity', function ($trail) {
    $trail->push(__('strings.activity.index'), route('activity'));
});

Breadcrumbs::for('cleared', function ($trail) {
    $trail->push(__("strings.cleared"), route('cleared'));
});


Breadcrumbs::for('activity.log.show', function ($trail) {
    $trail->push(__("Log Entry Details"), "");
});

Breadcrumbs::for('activity.log.delete', function ($trail) {
    $trail->push(__("Clear Log Entry"), "");
});

Breadcrumbs::for('clear-activity', function ($trail) {
    $trail->push(__("Clear Activity"), route('clear-activity'));
});

Breadcrumbs::for('destroy-activity', function ($trail) {
    $trail->push(__("Delete Activity"), route('destroy-activity'));
});

Breadcrumbs::for('restore-activity', function ($trail) {
    $trail->push(__("Restore Activity"), route('restore-activity'));
});
