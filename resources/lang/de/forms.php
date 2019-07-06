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
        'dropdown_first' => 'Bitte wählen',
        'cancel'     => 'Abbrechen',
        'back'       => 'Zurück',
        'next'       => 'Mehr',
        'edit'       => 'Bearbeiten',
        'save_edits' => 'Änderungen speichern',
        'name'       => 'Name',
        'confirm'    => 'Bist du sicher?',
    ],

    'auth' => [
        'username' => 'Benutzername',
        'password' => 'Passwort',
        'login'    => 'Anmelden',
    ],

    'author' => [
        'create' => 'Verfasser hinzufügen',
        'examples' => [
            'name' => 'z.B. Benjamin Ammann',
        ],
    ],

    'category' => [
        'create' => 'Kategorie hinzufügen',
        'examples' => [
            'name' => 'z.B. Apéros'
        ],
    ],

    'ingredient' => [
        'create'   => 'Zutat hinzufügen',
        'edit'     => 'Zutat ändern',
        'examples' => [
            'amount' => 'z.B. 50'
        ],
        'ingredient' => 'Zutat',
        'prep'       => 'Vorbereitung',
        'alternate'  => 'Diese Zutat als Alternative zu:',
        'position'   => 'Position',
    ],

    'ingredient-detail-group' => [
        'create'   => 'Gruppe hinzufügen',
        'edit'     => 'Gruppe ändern',
        'examples' => [
            'name' => 'z.B. Glasur'
        ],
    ],

    'prep' => [
        'create' => 'Vorbereitung hinzufügen',
        'examples' => [
            'name' => 'z.B. gehackt',
        ],
    ],

    'rating_criterion' => [
        'create' => 'Bewertungs-Kriterium hinzufügen',
        'examples' => [
            'name' => 'z.B. Geschmack',
        ],
    ],

    'rating' => [
        'create' => 'Bewertung hinzufügen',
        'edit'   => 'Bewertung bearbeiten',
        'examples' => [
            'name' => 'z.B. Geschmack'
        ],
        'rating'    => 'Bewertung',
        'criterion' => 'Kriterium',
        'comment'   => 'Kommentar',
    ],

    'recipe' => [
        'create' => 'Rezept hinzufügen',
        'examples' => [
            'name' => 'z.B. Benis Spezialkukis',
        ],
        'author'   => 'Verfasser',
        'category' => 'Kategorie',
        'tag'      => 'Tags',
        'yield_amount' => 'Portionen',
        'preparation_time' => 'Zubereitungszeit',
        'instructions' => 'Zubereitung',
        'photo' => 'Foto (max. 2MB)',
        'delete_old_photo' => 'Altes Foto löschen?',
        'overwrite_old_photo' => 'Altes Foto überschreiben (max 2MB)',
        'complexity' => 'Schwierigkeitsgrad',
        'simple' => 'Einfach',
        'normal' => 'Normal',
        'difficult' => 'Schwierig',
    ],

    'import' => [
        'create' => 'Rezept importieren',
        'file'   => 'Rezept (*.kreml)',
    ],

    'tag' => [
        'create' => 'Tag erstellen',
        'examples' => [
            'name' => 'z.B. Vegetarisch',
        ],
    ],

    'search' => [
        'create' => 'Rezept suchen',
        'examples' => [
            'term' => 'z.B. Kartoffel',
        ],
        'meta_description' => 'Einfach und schnell in über :count Rezepten suchen.',
        'item' => 'Suchen in',
        'items' => [
            'author' => 'Verfasser',
            'category' => 'Kategorien',
            'tag' => 'Tags',
            'recipe_preparation' => 'Rezept / Zubereitung',
            'ingredient' => 'Zutaten',
        ],
        'term' => 'Suchbegriff',
        'category' => [
            'title' => 'Nach Kategorie',
            'text'  => 'Hier findest du alle Kategorien und die dazu passenden Rezepte.',
        ],
        'author' => [
            'title' => 'Nach Verfasser',
            'text'  => 'Hier findest du alle Verfasser und deren Rezepte.',
        ],
        'tag' => [
            'title' => 'Nach Tags',
            'text'  => 'Hier findest du alle Tags und deren Rezepte.',
        ],
    ],

    'unit' => [
        'create' => 'Enheit erstellen',
        'examples' => [
            'name' => 'z.B. Flasche',
            'name_shortcut' => 'z.B. Fl.',
            'name_plural'   => 'z.B. Flaschen',
            'name_plural_shortcut' => 'z.B. Fl.',
        ],
        'name' => 'Name (Singular)',
        'name_shortcut' => 'Abkürzung (Singular)',
        'name_plural'   => 'Name (Plural)',
        'name_plural_shortcut' => 'Abkürzung (Plural)',
    ],

    'user' => [
        'edit'  => 'Profil bearbeiten',
        'email' => 'E-Mail',
        'current_password' => 'Aktuelles Passwort',
        'let_empty' => '(Leer lassen um nicht zu ändern)',
        'new_password' => 'Neues Passwort',
        'new_password_confirm' => 'Passwort bestätigen',
    ],

];
