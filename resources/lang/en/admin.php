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
    ],
    'header' => [
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
        ],
    ],
];
