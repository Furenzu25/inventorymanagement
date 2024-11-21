Broadcast::channel('admin.notifications', function ($user) {
    return $user->is_admin;
});
