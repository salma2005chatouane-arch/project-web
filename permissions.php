<?php
$permissions = [
    'admin' => [
        'manage_users',
        'manage_formations',
        'manage_sessions',
        'manage_inscriptions',
        'manage_formateurs',
        'view_dashboard_admin',
        'view_stats'
    ],
    'rh' => [
        'manage_formations',
        'manage_sessions',
        'manage_inscriptions',
        'manage_formateurs',
        'view_dashboard_rh',
        'view_certificats',
        'view_stats'
    ],
    'formateur' => [
        'view_dashboard_formateur',
        'view_my_sessions'
    ],
    'employe' => [
        'view_dashboard_employe',
        'view_catalogue',
        'register_session',
        'view_my_certificats'
    ]
];

function hasPermission($permission)
{
    if (!isset($_SESSION['role']))
        return false;
    global $permissions;
    $role = $_SESSION['role'];
    return isset($permissions[$role]) && in_array($permission, $permissions[$role]);
}

function hasRole($role)
{
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

function hasAnyRole($roles)
{
    return isset($_SESSION['role']) && in_array($_SESSION['role'], $roles);
}

function requireRole($role)
{
    if (!hasRole($role)) {
        header('Location: access_denied.php');
        exit;
    }
}
?>