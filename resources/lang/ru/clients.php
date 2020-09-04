<?php

return[
    'title'             => 'Клиенты',
    'page_title'        => 'Клиенты',
    'button_add_new'    => 'Добавить клиента',

    'table' => [
        'table_header' => [
            'th_1'  => '#',
            'th_2'  => 'Название компании',
            'th_3'  => 'Email',
            'th_4'  => 'Шлюз 1',
            'th_5'  => 'Шлюз 2',
            'th_6'  => 'Действия',
        ],

        'table_footer' => [
            'th_1'  => '#',
            'th_2'  => 'Название компании',
            'th_3'  => 'Email',
            'th_4'  => 'Шлюз 1',
            'th_5'  => 'Шлюз 2',
            'th_6'  => 'Действия',
        ],

        'button_edit'   => 'Редактировать',
        'button_delete' => 'Удалить',
    ],

    'add'   => [
        'title'         => 'Добавить клиента',
        'page_title'    => 'Добавить клиента',
        'button_save'   => 'Сохранить'
    ],
    'edit'   => [
        'title'         => 'Редактировать клиента',
        'page_title'    => 'Редактировать клиента',
        'button_edit'   => 'Редактировать',
        'dont_want_to_change_password'  => 'Если не хотите менять пароль - оставьте поле пустым.',
    ],

    'add_edit' => [
        'label_name'                => 'Название компании',
        'placeholder_name'          => 'Название компании',
        'label_login'               => 'Login (email)',
        'placeholder_login'         => 'Login (email)',
        'label_password'            => 'Пароль',
        'placeholder_password'      => 'Пароль',
        'generate'                  => 'Генерировать пароль',
        'label_payment_gateways'    => 'Доступные платежные системы',
        'settings'                  => 'Настройки',
        'values'                    => 'Значение',
        'currency'                  => 'Валюта',
        'rolling'                   => 'Rolling',
        'transaction_percent'       => 'Процент от транзакции',
        'transaction_cost'          => 'Стоимость транзакции',
        'refund'                    => 'Refund',
        'chargeback'                => 'Chargeback',
        'hold'                      => 'Hold (дней)',
        'min_payout'                => 'Минимальная выплата (в валюте шлюза)',
        'payment_methods'           => 'Доступные способы выплаты',
        'payout_cost'               => 'Стоимость выплаты',
        'button_back'               => 'Назад',
    ],



    'modal' => [
        'modal_title'   => 'Удаление клиента',
        'modal_body'    => 'Вы действительно хотите удалить клиента: ',
        'button_delete' => 'Удалить',
        'button_close'  => 'Закрыть',
    ],
];
