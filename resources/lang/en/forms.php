<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Form Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used various messages that we need
    | to display in forms.
    |
    */

    'global' => [
        'dropdown_first' => 'Please choose',
        'cancel'     => 'Cancel',
        'back'       => 'Back',
        'next'       => 'More',
        'edit'       => 'Edit',
        'save_edits' => 'Save changes',
        'name'       => 'Name',
        'confirm'    => 'Are you sure?',
    ],

    'auth' => [
        'username' => 'Username',
        'password' => 'Password',
        'login'    => 'Login',
    ],

    'author' => [
        'create' => 'Add author',
        'examples' => [
            'name' => 'e.g. Benjamin Ammann',
        ],
    ],

    'category' => [
        'create' => 'Add category',
        'examples' => [
            'name' => 'e.g. aperitif'
        ],
    ],

    'ingredient' => [
        'create'   => 'Add ingredient',
        'edit'     => 'Edit ingredient',
        'examples' => [
            'amount' => 'e.g. 50'
        ],
        'ingredient' => 'Ingredient',
        'prep'       => 'Prep',
        'alternate'  => 'This ingredient as alternate to:',
        'position'   => 'Position',
    ],

    'ingredient-detail-group' => [
        'create'   => 'Add group',
        'edit'     => 'Edit group',
        'examples' => [
            'name' => 'e.g. gloss'
        ],
    ],

    'prep' => [
        'create' => 'Add prep',
        'examples' => [
            'name' => 'e.g. cut',
        ],
    ],

    'rating_criterion' => [
        'create' => 'Add rating criterion',
        'examples' => [
            'name' => 'e.g. taste',
        ],
    ],

    'rating' => [
        'create' => 'Add rating',
        'edit'   => 'Edit rating',
        'examples' => [
            'name' => 'z.g. taste'
        ],
        'rating'    => 'Rating',
        'criterion' => 'Criterion',
        'comment'   => 'Comment',
    ],

    'recipe' => [
        'create' => 'Add recipe',
        'examples' => [
            'name' => 'e.g. Benis Spezialkukis',
        ],
        'author'   => 'Author',
        'category' => 'Category',
        'tag'      => 'Tags',
        'yield_amount' => 'Yield amount',
        'preparation_time' => 'Preparation time',
        'instructions' => 'Instructions',
        'photo' => 'Picture (max. 2MB)',
        'delete_old_photo' => 'Delete old photo?',
        'overwrite_old_photo' => 'Overwrite old photo (max 2MB)',
        'complexity' => 'Complexity',
        'simple' => 'Simple',
        'normal' => 'Normal',
        'difficult' => 'Difficult',
    ],

    'import' => [
        'create' => 'Import recipe',
        'file' => 'Recipe (*.kreml)',
    ],

    'tag' => [
        'create' => 'Create tag',
        'examples' => [
            'name' => 'e.g. vegetarian',
        ],
    ],

    'search' => [
        'create' => 'Search recipe',
        'examples' => [
            'term' => 'e.g. Potato',
        ],
        'meta_description' => 'Search easy and fast in over :count recipes.',
        'item' => 'Search in',
        'items' => [
            'author' => 'Author',
            'category' => 'Category',
            'tag' => 'Tags',
            'recipe_preparation' => 'Recipe / Preparation',
            'ingredient' => 'Ingredients',
        ],
        'term' => 'Search term',
        'category' => [
            'title' => 'Categories',
            'text'  => 'Here you\'ll find all categories and the proper recipes.',
        ],
        'author' => [
            'title' => 'Author',
            'text'  => 'Here you\'ll find all authors and whose recipes.',
        ],
        'tag' => [
            'title' => 'Tags',
            'text'  => 'Hier findest du alle Tags und deren Rezepte.',
        ],
    ],

    'unit' => [
        'create' => 'Create unit',
        'examples' => [
            'name' => 'z.g. Gram',
            'name_shortcut' => 'e.g. g.',
            'name_plural' => 'e.g. grams',
            'name_plural_shortcut' => 'e.g. g.',
        ],
        'name' => 'Name (singular)',
        'name_shortcut' => 'Shortcut (singular)',
        'name_plural'   => 'Name (plural)',
        'name_plural_shortcut' => 'Shortcut (plural)',
    ],

    'user' => [
        'edit' => 'Edit profile',
        'email' => 'E-Mail',
        'current_password' => 'Current passwort',
        'let_empty' => '(Leave empty to change nothing)',
        'new_password' => 'New password',
        'new_password_confirm' => 'Confirm password',
    ],

];
