<?php
return [
    'sidebar' => [
        'header' => 'MAIN NAVIGATION',
        'tag' => [
            'parent' => 'Tags',
            'index' => 'Tags',
            'create' => 'Create tag',
        ],
        'category' => [
            'parent' => 'Categories',
            'index' => 'Categories',
            'create' => 'Create category',
        ],
        'user' => [
            'parent' => 'Users',
            'index' => 'Users',
            'create' => 'Create user',
        ],
    ],
    'header' => [
        'title' => 'E-Document Control Panel',
        'logo-mini' => '<span class="logo-mini"><b>E</b>D</span>',
        'logo' => '<span class="logo-lg"><b>E</b>-Document</span>',
        'toggle-navigation' => 'Toggle navigation',
    ],
    'footer' => [
        'version' => 'Version 1.0',
        'copyright' => '<strong>Copyright &copy; 2017 <a href="#">Ngoc Khuong</a>.</strong> All rights reserved.',
    ],
    'dashboard' => [
        'title' => 'Dashboard',
    ],
    'error' => [
        '404' => [
            'title' => 'Page Not Found',
            'page-header' => [
                'page_title' => '404 Error Page',
                'page_description' => 'Page not found',
            ],
            'warning' => 'Oops! Page not found.',
            'message' => 'We could not find the page you were looking for. Meanwhile, you may <a href=":url">return to dashboard</a>.',
        ],
    ],
    'tag' => [
        'title' => 'Tags',
        'message' => [
            'create-success' => 'Create Successfully!',
            'create-error' => 'Create Error! Please try again',
            'show-edit-error' => 'Edit Error! Please try again',
            'edit-success' => 'Edit Successfully!',
            'edit-error' => 'Edit Error! Please try again',
            'delete-success' => 'Delete Successfully!',
            'delete-error' => 'Delete Error! Please try again',
        ],
        'index' => [
            'title' => 'Tags',
            'page-header' => [
                'page_title' => 'Tags',
                'page_description' => 'Display the tag list',
            ],
            'table' => [
                'name' => 'Name',
                'description' => 'Description',
                'slug' => 'Slug',
                'action' => 'Action',
                'no-record' => 'There are no tags',
                'edit' => 'Edit',
                'delete' => 'Delete',
                'delete-confirm' => 'Do you want to delete ":name" tag?',
            ],
        ],
        'create' => [
            'title' => 'Create tag',
            'page-header' => [
                'page_title' => 'Tags',
                'page_description' => 'Create the tag',
            ],
            'form' => [
                'name' => 'Name',
                'slug' => 'Slug',
                'description' => 'Description',
                'submit' => 'Create',
            ],
        ],
        'edit' => [
            'title' => 'Edit tag',
            'page-header' => [
                'page_title' => 'Tags',
                'page_description' => 'Edit the tag',
            ],
            'form' => [
                'name' => 'Name',
                'slug' => 'Slug',
                'description' => 'Description',
                'submit' => 'Edit',
            ],
        ],
    ],
    'category' => [
        'title' => 'Categories',
        'none' => 'None',
        'message' => [
            'create-success' => 'Create Successfully!',
            'create-error' => 'Create Error! Please try again',
            'show-edit-error' => 'Edit Error! Please try again',
            'edit-success' => 'Edit Successfully!',
            'edit-error' => 'Edit Error! Please try again',
            'delete-success' => 'Delete Successfully!',
            'delete-error' => 'Delete Error! Please try again',
        ],
        'index' => [
            'title' => 'Categories',
            'page-header' => [
                'page_title' => 'Categories',
                'page_description' => 'Display the category list',
            ],
            'table' => [
                'name' => 'Name',
                'description' => 'Description',
                'slug' => 'Slug',
                'parent' => 'Parent',
                'action' => 'Action',
                'no-record' => 'There are no categories',
                'edit' => 'Edit',
                'delete' => 'Delete',
                'delete-confirm' => 'Do you want to delete ":name" category?',
            ],
            'message' => [
                'delete-success' => 'Delete Successfully!',
                'delete-error' => 'Delete Error! Please try again',
            ],
        ],
        'create' => [
            'title' => 'Create category',
            'page-header' => [
                'page_title' => 'Categories',
                'page_description' => 'Create the category',
            ],
            'form' => [
                'name' => 'Name',
                'slug' => 'Slug',
                'category' => 'Parent Category',
                'description' => 'Description',
                'submit' => 'Create',
            ],
        ],
        'edit' => [
            'title' => 'Edit category',
            'page-header' => [
                'page_title' => 'Categories',
                'page_description' => 'Edit the category',
            ],
            'form' => [
                'name' => 'Name',
                'slug' => 'Slug',
                'category' => 'Parent Category',
                'description' => 'Description',
                'submit' => 'Edit',
            ],
        ],
    ],
    'user' => [
        'title' => 'Users',
        'message' => [
            'create-success' => 'Create Successfully!',
            'create-error' => 'Create Error! Please try again',
            'show-edit-error' => 'Edit Error! Please try again',
            'edit-success' => 'Edit Successfully!',
            'edit-error' => 'Edit Error! Please try again',
            'delete-success' => 'Delete Successfully!',
            'delete-error' => 'Delete Error! Please try again',
        ],
        'index' => [
            'title' => 'Users',
            'page-header' => [
                'page_title' => 'Users',
                'page_description' => 'Display the user list',
            ],
            'table' => [
                'username' => 'Username',
                'email' => 'Email',
                'firstname' => 'First Name',
                'lastname' => 'Last Name',
                'action' => 'Action',
                'no-record' => 'There are no users',
                'edit' => 'Edit',
                'delete' => 'Delete',
                'delete-confirm' => 'Do you want to delete ":name" user?',
            ],
        ],
        'create' => [
            'title' => 'Create user',
            'page-header' => [
                'page_title' => 'Users',
                'page_description' => 'Create the user',
            ],
            'form' => [
                'username' => 'Username',
                'email' => 'Email',
                'firstname' => 'First Name',
                'lastname' => 'Last Name',
                'password' => 'Password',
                'wallet' => 'Wallet',
                'wallet_coin' => 'coin',
                'free_download' => 'Free Download',
                'free_download_times' => 'times',
                'role' => 'Role',
                'avatar' => 'Avatar',
                'status' => 'Status',
                'submit' => 'Create',
            ],
        ],
        'edit' => [
            'title' => 'Edit user',
            'page-header' => [
                'page_title' => 'Users',
                'page_description' => 'Edit the user',
            ],
            'form' => [
                'username' => 'Username',
                'email' => 'Email',
                'firstname' => 'First Name',
                'lastname' => 'Last Name',
                'password' => 'Password',
                'wallet' => 'Wallet',
                'wallet_coin' => 'coin',
                'free_download' => 'Free Download',
                'free_download_times' => 'times',
                'role' => 'Role',
                'avatar' => 'Avatar',
                'status' => 'Status',
                'submit' => 'Edit',
            ],
        ],
    ],
];
