<?php

return[
    'title'             => 'Outlets',
    'page_title'        => 'Торговые точки',
    'button_add_new'    => 'Добавить торговую точку',

    'table' => [
        'table_header' => [
            'th_1'  => '#',
            'th_2'  => 'Название',
            'th_3'  => 'Адрес сайта',
            'th_4'  => 'Шлюз 1',
            'th_5'  => 'Шлюз 2',
            'th_6'  => 'Статус',
            'th_7'  => 'Success URL',
            'th_8'  => 'Failed URL',
            'th_9'  => 'Callback URL',
            'th_10' => 'API Key',
            'th_11' => 'Secret Key',
            'th_12' => 'Действия',
        ],

        'table_footer' => [
            'th_1'  => '#',
            'th_2'  => 'Название',
            'th_3'  => 'Адрес сайта',
            'th_4'  => 'Шлюз 1',
            'th_5'  => 'Шлюз 2',
            'th_6'  => 'Статус',
            'th_7'  => 'Success URL',
            'th_8'  => 'Failed URL',
            'th_9'  => 'Callback URL',
            'th_10' => 'API Key',
            'th_11' => 'Secret Key',
            'th_12' => 'Действия',
        ],

        'test'          => 'Тестовый',
        'active'        => 'Активный',
        'button_show'   => 'Показать',
        'button_edit'   => 'Редактировать',
        'button_delete' => 'Удалить',
    ],

    'add'   => [
        'title'         => 'Добавить торговую точку',
        'page_title'    => 'Добавить торговую точку',
        'button_save'   => 'Сохранить'
    ],
    'edit'   => [
        'title'         => 'Редактировать торговую точку',
        'page_title'    => 'Редактировать торговую точку',
        'button_edit'   => 'Редактировать',
    ],

    'add_edit' => [
        'label_name'                => 'Название торговой точки',
        'placeholder_name'          => 'Название торговой точки',
        'label_outlet_url'          => 'Адрес сайта',
        'placeholder_outlet_url'    => 'https://www.sitename.com',
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
        'label_outlet_status'       => 'Статус',
        'label_radio_active'        => 'Активный',
        'label_radio_test'          => 'Тестовый',
        'label_success_url'         => 'Success URL',
        'placeholder_success_url'   => 'https://www.sitename.com/success_page',
        'label_failed_url'          => 'Failed URL',
        'placeholder_failed_url'    => 'https://www.sitename.com/failed_page',
        'label_callback_url'        => 'Callback URL',
        'placeholder_callback_url'  => 'https://www.sitename.com/callback_page',
    ],


    'modal_delete' => [
        'modal_title'   => 'Удаление торговую точку',
        'modal_body'    => 'Вы действительно хотите удалить торговую точку: ',
        'button_delete' => 'Удалить',
        'button_close'  => 'Закрыть',
    ],

    'modal_api_key' => [
        'modal_title'   => 'API Key',
        'button_copy'   => 'Копировать API Key',
        'button_close'  => 'Закрыть',
        'api_key_copied' => 'API Key скопирован в буфер',
    ],

    'modal_secret_key' => [
        'modal_title'   => 'Secret Key',
        'button_copy'   => 'Копировать Secret Key',
        'button_close'  => 'Закрыть',
        'api_key_copied' => 'Secret Key скопирован в буфер',
    ],

    'outlet_validator' => [
        'outlet_url'    => 'Адрес сайта не является действительным.',
        'success_url'   => 'Success URL не является действительным.',
        'failed_url'    => 'Failed URL не является действительным.',
        'callback_url'  => 'Callback URL не является действительным.',
        'unique_url'    => 'Торговая точка с таким адресом уже существует',
    ],

];
