<?php
return [
    'none' => '',
    'status' => [
        'error' => 400,
        'success' => 200,
    ],
    'avatar_folder' => 'images' . DIRECTORY_SEPARATOR . 'avatars',
    'document_image_folder' => 'images' . DIRECTORY_SEPARATOR . 'documents',
    'storage_folder' => 'storage',
    'storage_public_folder' => 'app' . DIRECTORY_SEPARATOR . 'public',
    'content_type' => 'Content-Type: ',
    'terms_default' => [
        'name' => '',
        'slug' => '',
    ],

    'term_taxonomy_default' => [
        'term_id' => 0,
        'taxonomy' => '',
        'parent' => 0,
    ],

    'documents_default' => [
        'document_status' => 0,
        'comment_status' => 0,
        'coin' => 0,
        'page_count' => 0,
        'view_count' => 0,
        'download_count' => 0,
    ],

    'comments_default' => [
        'parent' => 0,
    ],

    'options_default' => [
        'name' => '',
    ],

    'users_default' => [
        'avatar' => '',
        'free_download' => 3,
        'uploaded_count' => 0,
        'wallet' => 0,
        'status' => 0,
        'role' => '',
    ],

    'pagination' => [
        'number_per_page' => 10,
    ],

    'tag' => [
        'taxonomy' => 'tag',
    ],

    'category' => [
        'taxonomy' => 'category',
        'none' => 0,
    ],

    'user' => [
        'status_active' => 1,
        'status_deactive' => 0,
    ],

    'document' => [
        'status' => [
            'approved' => 1,
            'unapproved' => 0,
        ],
        'type' => [
            'pdf' => 2,
            'doc' => 3,
            'docx' => 3,
            'ppt' => 4,
            'pptx' => 4,
            'csv' => 5,
        ],
        'doc_list_cnt_end_div' => 5,
        'session_download_key' => 'download',
        'session_force_download_key' => 'force_download',
        'download_type' => 'download',
        'force_download_type' => 'force_download',
    ],

    'public' => [
        'homepage' => [
            'number_of_documents' => 20,
        ],
    ],
];
