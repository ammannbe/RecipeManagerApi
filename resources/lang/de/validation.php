<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute muss akzeptiert werden.',
    'active_url' => ':attribute ist keine gültige URL.',
    'after' => ':attribute muss ein Datum nach :date sein.',
    'after_or_equal' => ':attribute muss ein Datum nach oder gleich :date sein.',
    'alpha' => ':attribute darf nur Buchstaben beinhalten.',
    'alpha_dash' => ':attribute darf nur Buchstaben, Nummern, Binde- oder Unterstriche beinhalten.',
    'alpha_num' => ':attribute darf nur Buchstaben oder Nummern beinhalten.',
    'array' => ':attribute muss ein Array sein.',
    'before' => ':attribute muss ein Datum vor :date sein.',
    'before_or_equal' => ':attribute muss ein Datum vor oder gleich :date sein.',
    'between' => [
        'numeric' => ':attribute muss zwischen :min und :max liegen.',
        'file' => ':attribute muss zwischen :min und :max Kilobytes liegen.',
        'string' => ':attribute muss zwischen :min und :max Zeichen liegen.',
        'array' => ':attribute muss zwischen :min und :max Elemnte besitzen.',
    ],
    'boolean' => 'Das :attribute Feld muss true oder false sein.',
    'confirmed' => 'Die :attribute Bestätigung stimmt nicht überein.',
    'date' => ':attribute ist kein gültiges Datum.',
    'date_equals' => ':attribute muss gleich :date sein.',
    'date_format' => ':attribute passt nicht zum Format :format.',
    'different' => ':attribute und :other müssen unterschiedlich sein.',
    'digits' => ':attribute müssen :digits Ziffern sein.',
    'digits_between' => ':attribute muss zwischen :min und :max Ziffern sein.',
    'dimensions' => ':attribute hat keine gültige Bildgrösse.',
    'distinct' => ':attribute hat ein doppelter Wert.',
    'email' => ':attribute muss eine gültige E-Mail-Adresse sein.',
    'exists' => ':attribute ist ungültig.',
    'file' => ':attribute muss eine Datei sein.',
    'filled' => ':attribute muss ein Wert haben.',
    'gt' => [
        'numeric' => ':attribute muss grösser als :value sein.',
        'file' => ':attribute muss grösser als :value Kilobytes sein.',
        'string' => ':attribute muss grösser als :value Zeichen sein.',
        'array' => ':attribute muss mehr als :value Elemente besitzen.',
    ],
    'gte' => [
        'numeric' => ':attribute muss grösser oder gleich :value sein.',
        'file' => ':attribute muss grösser oder gleich :value Kilobytes sein.',
        'string' => ':attribute muss grösser oder gleich :value Zeichen sein.',
        'array' => ':attribute muss mehr oder gleich :value Elemente besitzen.',
    ],
    'image' => ':attribute muss ein Bild sein.',
    'in' => ':attribute ist ungültig.',
    'in_array' => ':attribute existiert nicht in :other.',
    'integer' => ':attribute muss eine Ganzzahl sein.',
    'ip' => ':attribute muss eine gültige IP Adresse sein.',
    'ipv4' => ':attribute muss eine gültige IPv4 Adresse sein.',
    'ipv6' => ':attribute muss eine gültige IPv6 Adresse sein.',
    'json' => ':attribute muss einen gültigen JSON-String sein.',
    'lt' => [
        'numeric' => ':attribute muss weniger :value sein.',
        'file' => ':attribute muss weniger :value Kilobytes sein.',
        'string' => ':attribute muss weniger :value Zeichen sein.',
        'array' => ':attribute muss weniger als :value Elemente besitzen.',
    ],
    'lte' => [
        'numeric' => ':attribute muss weniger oder gleich :value sein.',
        'file' => ':attribute muss weniger oder gleich :value Kilobytes sein.',
        'string' => ':attribute muss weniger oder gleich :value Zeichen sein.',
        'array' => ':attribute darf nicht mehr oder gleich :value Elemente besitzen.',
    ],
    'max' => [
        'numeric' => ':attribute darf nicht grösser als :max sein.',
        'file' => ':attribute darf nicht grösser als :max Kilobytes sein.',
        'string' => ':attribute darf nicht grösser als :max Zeichen sein.',
        'array' => ':attribute darf nicht mehr als :max Elemente besitzen.',
    ],
    'mimes' => ':attribute muss eine Datei des Typs: :values sein.',
    'mimetypes' => ':attribute muss eine Datei des Typs: :values sein.',
    'min' => [
        'numeric' => ':attribute muss mindestens :min sein.',
        'file' => ':attribute muss mindestens :min Kilobytes sein.',
        'string' => ':attribute muss mindestens :min Zeichen sein.',
        'array' => ':attribute muss mindestens :min Elemente besitzen.',
    ],
    'not_in' => ':attribute ist ungültig.',
    'not_regex' => 'Das :attribute-Format ist ungültig.',
    'numeric' => ':attribute muss eine Nummer sein.',
    'present' => ':attribute muss präsent sein.',
    'regex' => 'Das :attribute-Format ist ungültig.',
    'required' => ':attribute ist notwendig.',
    'required_if' => ':attribute ist notwendig, wenn :other gleich :value ist.',
    'required_unless' => ':attribute ist notwendig, ausser :other in :values ist.',
    'required_with' => ':attribute ist notwendig, wenn :values präsent ist.',
    'required_with_all' => ':attribute ist notwendig, wenn :values präsent sind.',
    'required_without' => ':attribute ist notwendig, wenn :values nicht präsent sind.',
    'required_without_all' => ':attribute ist notwendig, wenn keine :values präsent sind.',
    'same' => ':attribute und :other müssen übereinstimmen.',
    'size' => [
        'numeric' => ':attribute muss :size gross sein.',
        'file' => ':attribute muss :size Kilobytes gross sein.',
        'string' => ':attribute muss :size Zeichen gross sein.',
        'array' => ':attribute muss :size Elemente beinhalten.',
    ],
    'starts_with' => ':attribute muss mit einer der folgenden Werte beginnen: :values',
    'string' => ':attribute muss eine Zeichenkette sein.',
    'timezone' => ':attribute muss eine gültige Zeitzone sein.',
    'unique' => ':attribute ist bereits vergeben.',
    'uploaded' => ':attribute konnte nicht hochgeladen werden.',
    'url' => 'Das :attribute-Format ist ungültig.',
    'uuid' => ':attribute muss eine gültige UUID sein.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],


    'noscript' => 'Aktiviere JavaScript um von allen Funktionen zu profitieren.',

];
