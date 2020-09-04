<?php

return[
    'title'         => 'Payouts Create',
    'page_title'    => 'Создать выплату',

    'label_payment_gateways'    => 'Доступные платежные системы',
    'label_amount'              => 'Сумма',
    'placeholder_amount_1'      => 'Доступно для снятия не более :amount',
    'label_card_no'         => 'Номер карты',
    'placeholder_card_no'   => 'Номер карты',
    'placeholder_amount_2'      => 'Доступно для снятия от :min до :max',
    'placeholder_amount_3'      => 'Минимальная сумма для снятия :min',
    'label_iban'                => 'IBAN',
    'placeholder_iban'          => 'IBAN',
    'label_beneficiary'         => 'Beneficiary',
    'placeholder_beneficiary'   => 'Beneficiary',
    'label_country'             => 'Страна',
    'option_country'            => '-- Выберите страну --',
    'label_city'                => 'Город',
    'placeholder_city'          => 'Город',
    'label_address'             => 'Адрес',
    'placeholder_address'       => 'Адрес',
    'label_bank_name'           => 'Название банка',
    'placeholder_bank_name'     => 'Название банка',
    'label_swift'               => 'SWIFT',
    'placeholder_swift'         => 'SWIFT',
    'button_create'             => 'Создать выплату',

    'validator' => [
        'amount_1_require'      => 'Поле Сумма необходимо заполнить',
        'card_no_require'   => 'Поле Номер карты необходимо заполнить',
        'card_no_min'       => 'Поле Номер карты должно содержать 16 символов',
        'card_no_max'       => 'Поле Номер карты должно содержать 16 символов',
        'amount_2_require'      => 'Поле Сумма необходимо заполнить',
        'iban_require'          => 'Поле IBAN необходимо заполнить',
        'beneficiary_required'  => 'Поле Beneficiary необходимо заполнить',
        'country_required'      => 'Поле Страна необходимо заполнить',
        'city_required'         => 'Поле Город необходимо заполнить',
        'address_required'      => 'Поле Адрес необходимо заполнить',
        'bank_name_required'    => 'Поле Название банка необходимо заполнить',
        'swift_required'        => 'Поле SWIFT необходимо заполнить',
    ],


];
