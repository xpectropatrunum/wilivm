<?php

return [
    'user_source'=>'store',
    'prefix_powernation_id'=>'ID-',
    'prefix_clinic_id'=>'CL-',
    'prefix_un'=>'UN-',
    'prefix_doctor_id'=>'DR-',
    'blood_types' => [
        '1'=>'O−',
        '2'=>'O+',
        '3'=>'A−',
        '4'=>'A+',
        '5'=>'B−',
        '6'=>'B+',
        '7'=>'AB−',
        '8'=>'AB+',
    ],
    'account_types'=> [
        '1'=> 'Organization',
        '2'=> 'Personal'
    ],
    'salutation'=> [
        '1'=> 'Mr',
        '2'=> 'Ms'
    ],
    'product_types'=> [
        '1'=> 'Simple product',
        '2'=> 'Variable product',
    ],
    'attribute_types'=> [
        '1'=> 'select',
        '2'=> 'radio',
        '3'=> 'color',
    ],
    'file_use_as'=> [
        'front'=> 'Front',
        'back'=> 'Back',
        'color'=> 'Color'
    ],
    'discount_types'=> [
        'percent'=> '%',
        'currency'=> '$',
    ],
    'currencies'=> [
        'BTC','ETH','USD','IRT','EUR'
    ],
    'attribute_type_select'=>1,
    'attribute_type_radio'=>2,
    'attribute_type_color'=>3,
    'product_type_simple'=>1,
    'product_type_variable'=>2,
    'default_currency' =>'USD',
    'default_country' => 3,
    'country_id_iran'=> 1,
    'salutation_mr'=> 1,
    'salutation_ms'=> 2,
    'organization_account_type'=> 1,
    'personal_account_type'=> 2,
    'group_access_visitor'=> 1,
    'group_access_customer'=> 2,
    'group_access_personal'=> 3,
    'group_access_organization'=> 4,
    'group_access_mr'=> 5,
    'group_access_ms'=> 6,
    'group_access_18'=> 7,
    'group_access_verified'=> 13,
    'preferences_group_ids' => [9,10,11,12]
];
