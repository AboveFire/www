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

    'accepted'             => 'Ce champ doit être accepté.',
    'active_url'           => 'Ce champ n\'est pas un lien valide.',
    'after'                => 'Ce champ doit être une date après :date.',
    'alpha'                => 'Ce champ ne peut que comporter des lettres.',
    'alpha_dash'           => 'Ce champ ne peut contenir que des lettres, des chiffres et des traits d\'union.',
    'alpha_num'            => 'Ce champ ne peut contenir que des lettres et des chiffres.',
    'array'                => 'Ce champ doit être une liste.',
    'before'               => 'Ce champ doit être une date avant :date.',
    'between'              => [
        'numeric' => 'La taille doit être entre :min et :max.',
        'file'    => 'La taille doit être entre :min et :max kilobytes.',
        'string'  => 'La taille doit être entre :min et :max caractères.',
        'array'   => 'Cette valeur doit comporter entre :min et :max items.',
    ],
    'boolean'              => 'Ce champ doit être vrai ou faux.',
    'confirmed'            => 'Cette confirmation n\'est pas valide.',
    'date'                 => 'Ce champ  n\'est pas une date valide.',
    'date_format'          => 'Ce champ doit être conforme au format :format.',
    'different'            => 'Ce champ et :other doivent différer.',
    'digits'               => 'Ce champ doit comporter :digits chiffre(s).',
    'digits_between'       => 'This must be between :min and :max digits.',
    'distinct'             => 'Ce champ a une valeur duppliquée.',
    'email'                => 'Ce champ doit être une adresse courriel valide.',
    'exists'               => 'La sélection est invalide.',
    'filled'               => 'Ce champ est requis.',
    'image'                => 'Ce champ doit être une image.',
    'in'                   => 'La sélection est invalide.',
    'in_array'             => 'Ce champ ne fait pas partie de :other.',
    'integer'              => 'Ce champ doit être un entier.',
    'ip'                   => 'Ce champ doit être une adresse IP valide.',
    'json'                 => 'Ce champ doit être un JSON valide',
    'max'                  => [
        'numeric' => 'La taille doit être de :max maximum.',
        'file'    => 'La taille doit être de :max kilobytes maximum.',
        'string'  => 'La taille doit être de :max caractères maximum.',
        'array'   => 'Ce champ doit comporter :max items maximum.',
    ],
    'mimes'                => 'Ce champ doit êter un fichier de type: :values.',
    'min'                  => [
        'numeric' => 'La taille doit être de :min au minimum.',
        'file'    => 'La taille doit être de :min kilobytes au minimum.',
        'string'  => 'La taille doit être de :min caractères au minimum.',
        'array'   => 'Ce champ doit comporter :min items au minimum.',
    ],
    'not_in'               => 'Ce champ est invalide.',
    'numeric'              => 'Ce champ doit être un  nombre.',
    'present'              => 'Ce champ doit être présent.',
    'regex'                => 'Ce format est invalide.',
    'required'             => 'Ce champ est requis.',
    'required_if'          => 'Ce champ est requis lorsque :other est :value.',
    'required_unless'      => 'Ce champ est requis sauf si :other est parmi les valeurs : :values.',
    'required_with'        => 'Ce champ est requis lorsque :values est présente.',
    'required_with_all'    => 'Ce champ est requis lorsque :values est présente.',
    'required_without'     => 'Ce champ est requis lorsque :values n\'est pas présente.',
    'required_without_all' => 'Ce champ est requis lorsque aucune des :values dont présentes.',
    'same'                 => 'Ce champ et :other doivent correspondre.',
    'size'                 => [
        'numeric' => 'La taille doit être de :size.',
        'file'    => 'La taille doit être de :size kilobytes.',
        'string'  => 'La taille doit être de :size caractères.',
        'array'   => 'Cette valeur doit contenir :size items.',
    ],
    'string'               => 'Cette valeur doit être une chaîne de caractères.',
    'timezone'             => 'Cette zone doit être valide.',
    'unique'               => 'Cette valeur est déjà prise.',
    'url'                  => 'Ce format est invalide.',

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
            'rule-name' => 'Foisy est le meilleur!',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
