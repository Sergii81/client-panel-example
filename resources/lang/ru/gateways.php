<?php

return[
    'title'             => 'Шлюзы',
    'page_title'        => 'Шлюзы',
    'button_add_new'    => 'Добавить шлюз',


    'table' => [
        'table_header'  => [
            'th_1'  => '#',
            'th_2'  => 'Название',
            'th_3'  => 'Валюта',
            'th_4'  => 'Rolling',
            'th_5'  => 'Процент от транзакции',
            'th_6'  => 'Стоимость транзакции',
            'th_7'  => 'Refunds',
            'th_8'  => 'Chargeback',
            'th_9'  => 'Hold',
            'th_10' => 'Минимальная выплата',
            'th_11' => 'Доступные способы выплаты',
            'th_12' => 'Стоимость выплаты',
            'th_13' => 'Действия',
        ],
        'table_footer'  => [
            'th_1'  => '#',
            'th_2'  => 'Название',
            'th_3'  => 'Валюта',
            'th_4'  => 'Rolling',
            'th_5'  => 'Процент от транзакции',
            'th_6'  => 'Стоимость транзакции',
            'th_7'  => 'Refunds',
            'th_8'  => 'Chargeback',
            'th_9'  => 'Hold',
            'th_10' => 'Минимальная выплата',
            'th_11' => 'Доступные способы выплаты',
            'th_12' => 'Стоимость выплаты',
            'th_13' => 'Действия',
        ],
        'button_edit'   => 'Редактировать',
        'button_delete' => 'Удалить',
    ],

    'add'   => [
        'title'         => 'Добавить шлюз',
        'page_title'    => 'Добавить шлюз',
        'button_save'   => 'Сохранить'
    ],
    'edit'   => [
        'title'         => 'Редактировать шлюз',
        'page_title'    => 'Редактировать шлюз',
        'button_edit'   => 'Редактировать'
    ],


    'add_edit' => [
        'label_name'                        => 'Название шлюза',
        'placeholder_name'                  => 'Название шлюза',
        'label_currency'                    => 'Валюта по умолчанию',
        'options_select_one'                => 'Выбор валюты по умолчанию',
        'label_rolling'                     => 'Rolling (%)',
        'placeholder_rolling'               => 'Величина rolling резерва',
        'label_transaction_percent'         => 'Процент от транзакции',
        'placeholder_transaction_percent'   => 'Процент от транзакции',
        'label_transaction_cost'            => 'Стоимость транзакции',
        'placeholder_transaction_cost'      => 'Стоимость транзакции',
        'label_refund'                      => 'Refund',
        'placeholder_refund'                => 'Refund',
        'label_chargeback'                  => 'Chargeback',
        'placeholder_chargeback'            => 'Chargeback',
        'label_hold'                        => 'Hold (дней)',
        'placeholder_hold'                  => 'Hold (дней)',
        'label_min_payout'                  => 'Минимальная выплата (в валюте шлюза)',
        'placeholder_min_payout'            => 'Минимальная выплата',
        'label_payment_methods'             => 'Доступные способы выплаты',
        'options_select_one_1'              => 'Доступные способы выплаты',
        'label_payout_cost'                 => 'Стоимость выплаты',
        'placeholder_payout_cost'           => 'Стоимость выплаты',
        'button_back'                       => 'Назад',
    ],

    'modal' => [
        'modal_title'   => 'Удаление шлюза',
        'modal_body'    => 'Вы действительно хотите удалить шлюз: ',
        'button_delete' => 'Удалить',
        'button_close'  => 'Закрыть',
    ],
];
