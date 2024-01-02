<?

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$data = [
    'NAME' => Loc::getMessage('DARNEO_PSCB_PAYMENT_MODULE_TITLE'),
    'SORT' => 100,
    'CODES' => [
        'PSCB_MERCHANT_ID' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_MERCHANT_ID_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_MERCHANT_ID_DESCR'),
            'SORT' => 10,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_GATE'),
        ],
        'PSCB_MERCHANT_KEY' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_MERCHANT_KEY_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_MERCHANT_KEY_DESCR'),
            'SORT' => 20,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_GATE'),
        ],
        'PSCB_MERCHANT_TEST' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_MERCHANT_TEST_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_MERCHANT_TEST_DESCR'),
            'SORT' => 30,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_GATE'),
            'INPUT' => [
                'TYPE' => 'Y/N'
            ],
            'DEFAULT' => [
                'PROVIDER_VALUE' => 'N',
                'PROVIDER_KEY' => 'INPUT'
            ]
        ],
        'PSCB_MERCHANT_METHOD' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_METHOD_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_METHOD_DESCR'),
            'SORT' => 40,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_HANDLER'),
            'TYPE' => 'SELECT',
            'INPUT' => [
                'TYPE' => 'ENUM',
                'OPTIONS' => [
                    '' => Loc::getMessage('PSCB_PAYMENT_API_METHOD_0'),
                    'ac' => Loc::getMessage('PSCB_PAYMENT_API_METHOD_1'),
                    'sbp' => Loc::getMessage('PSCB_PAYMENT_API_METHOD_2'),
                    'ym' => Loc::getMessage('PSCB_PAYMENT_API_METHOD_3'),
                    'qiwi' => Loc::getMessage('PSCB_PAYMENT_API_METHOD_4'),
                    'alfa' => Loc::getMessage('PSCB_PAYMENT_API_METHOD_5'),
                    'pscb_terminal' => Loc::getMessage('PSCB_PAYMENT_API_METHOD_6'),
                    'mobi-money' => Loc::getMessage('PSCB_PAYMENT_API_METHOD_7'),
                ]
            ],
            'DEFAULT' => [
                'PROVIDER_VALUE' => '',
                'PROVIDER_KEY' => 'INPUT'
            ]
        ],
        'PSCB_MERCHANT_HOLD' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_HOLD_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_HOLD_DESCR'),
            'SORT' => 50,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_HANDLER'),
            'INPUT' => [
                'TYPE' => 'Y/N'
            ],
            'DEFAULT' => [
                'PROVIDER_VALUE' => 'N',
                'PROVIDER_KEY' => 'INPUT'
            ]
        ],
        'PSCB_RETURN_URL' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_RETURN_URL_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_RETURN_URL_DESCR'),
            'SORT' => 60,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_HANDLER'),
        ],
        'PSCB_FAIL_URL' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_FAIL_URL_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_FAIL_URL_DESCR'),
            'SORT' => 70,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_HANDLER'),
        ],
        'PSCB_LANG' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_LANG_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_LANG_DESCR'),
            'SORT' => 90,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_HANDLER'),
            'TYPE' => 'SELECT',
            'INPUT' => [
                'TYPE' => 'ENUM',
                'OPTIONS' => [
                    'ru' => Loc::getMessage('PSCB_PAYMENT_API_LANG_1'),
                    'en' => Loc::getMessage('PSCB_PAYMENT_API_LANG_2'),
                ]
            ],
            'DEFAULT' => [
                'PROVIDER_VALUE' => 'ru',
                'PROVIDER_KEY' => 'INPUT'
            ]
        ],
        'PSCB_ORDER_ID' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_ORDER_ID_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_ORDER_ID_DESCR'),
            'SORT' => 1000,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_ORDER'),
            'DEFAULT' => [
                'PROVIDER_VALUE' => 'ORDER',
                'PROVIDER_KEY' => 'ACCOUNT_NUMBER'
            ]
        ],
        'PSCB_ORDER_AMOUNT' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_ORDER_AMOUNT_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_ORDER_AMOUNT_DESCR'),
            'SORT' => 1100,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_ORDER'),
            'DEFAULT' => [
                'PROVIDER_KEY' => 'PAYMENT',
                'PROVIDER_VALUE' => 'SUM'
            ]
        ],
        'PSCB_ORDER_EMAIL' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_ORDER_EMAIL_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_ORDER_EMAIL_DESCR'),
            'SORT' => 1200,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_ORDER'),
            'DEFAULT' => [
                'PROVIDER_VALUE' => '',
                'PROVIDER_KEY' => 'INPUT'
            ]
        ],
        'PSCB_ORDER_PHONE' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_ORDER_PHONE_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_ORDER_PHONE_DESCR'),
            'SORT' => 1300,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_ORDER'),
            'DEFAULT' => [
                'PROVIDER_VALUE' => '',
                'PROVIDER_KEY' => 'INPUT'
            ]
        ],
        'PSCB_ORDER_DESCRIPTION' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_ORDER_DESCRIPTION_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_ORDER_DESCRIPTION_DESCR'),
            'SORT' => 1400,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_ORDER'),
            'DEFAULT' => [
                'PROVIDER_KEY' => 'ORDER',
                'PROVIDER_VALUE' => 'USER_DESCRIPTION'
            ]
        ],
        'PSCB_OFD_ACTIVE' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_OFD_ACTIVE_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_OFD_ACTIVE_DESCR'),
            'SORT' => 10000,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_OFD'),
            'INPUT' => [
                'TYPE' => 'Y/N'
            ],
            'DEFAULT' => [
                'PROVIDER_VALUE' => 'N',
                'PROVIDER_KEY' => 'INPUT'
            ]
        ],
        'PSCB_OFD_TAX' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_DESCR'),
            'SORT' => 10010,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_OFD'),
            'TYPE' => 'SELECT',
            'INPUT' => [
                'TYPE' => 'ENUM',
                'OPTIONS' => [
                    'osn' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_1'),
                    'usn_income' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_2'),
                    'usn_income_outcome' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_3'),
                    'esn' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_4'),
                    'patent' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_5'),
                ]
            ],
            'DEFAULT' => [
                'PROVIDER_VALUE' => 'osn',
                'PROVIDER_KEY' => 'INPUT'
            ]
        ],
        'PSCB_OFD_EMAIL' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_OFD_EMAIL_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_OFD_EMAIL_DESCR'),
            'SORT' => 10020,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_OFD'),
            'DEFAULT' => [
                'PROVIDER_VALUE' => '',
                'PROVIDER_KEY' => 'INPUT'
            ]
        ],
        'PSCB_OFD_TYPE_PAYMENT' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_PAYMENT_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_PAYMENT_DESCR'),
            'SORT' => 10030,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_OFD'),
            'TYPE' => 'SELECT',
            'INPUT' => [
                'TYPE' => 'ENUM',
                'OPTIONS' => [
                    'full_prepayment' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_PAYMENT_1'),
                    'prepayment' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_PAYMENT_2'),
                    'advance' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_PAYMENT_3'),
                    'full_payment' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_PAYMENT_4'),
                ]
            ],
            'DEFAULT' => [
                'PROVIDER_VALUE' => 'full_prepayment',
                'PROVIDER_KEY' => 'INPUT'
            ]
        ],
        'PSCB_OFD_TYPE_SERVICE' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_SERVICE_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_SERVICE_DESCR'),
            'SORT' => 10040,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_OFD'),
            'TYPE' => 'SELECT',
            'INPUT' => [
                'TYPE' => 'ENUM',
                'OPTIONS' => [
                    'commodity' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_SERVICE_1'),
                    'job' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_SERVICE_2'),
                    'service' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_SERVICE_3'),
                    'payment' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_SERVICE_4'),
                    'lottery' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_SERVICE_5'),
                    'composite' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_SERVICE_6'),
                    'another' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_SERVICE_7'),
                ]
            ],
            'DEFAULT' => [
                'PROVIDER_VALUE' => 'commodity',
                'PROVIDER_KEY' => 'INPUT'
            ]
        ],
        'PSCB_OFD_TYPE_DELIVERY' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_DELIVERY_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_DELIVERY_DESCR'),
            'SORT' => 10045,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_OFD'),
            'TYPE' => 'SELECT',
            'INPUT' => [
                'TYPE' => 'ENUM',
                'OPTIONS' => [
                    'commodity' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_SERVICE_1'),
                    'job' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_SERVICE_2'),
                    'service' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_SERVICE_3'),
                    'payment' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_SERVICE_4'),
                    'lottery' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_SERVICE_5'),
                    'composite' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_SERVICE_6'),
                    'another' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TYPE_SERVICE_7'),
                ]
            ],
            'DEFAULT' => [
                'PROVIDER_VALUE' => 'service',
                'PROVIDER_KEY' => 'INPUT'
            ]
        ],
        'PSCB_OFD_TAX_ITEM' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_ITEM_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_ITEM_DESCR'),
            'SORT' => 10050,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_OFD'),
            'TYPE' => 'SELECT',
            'INPUT' => [
                'TYPE' => 'ENUM',
                'OPTIONS' => [
                    'none' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_ITEM_1'),
                    'vat0' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_ITEM_2'),
                    'vat10' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_ITEM_3'),
                    'vat20' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_ITEM_4'),
                    'vat110' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_ITEM_5'),
                    'vat120' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_ITEM_6'),
                ]
            ],
            'DEFAULT' => [
                'PROVIDER_VALUE' => 'none',
                'PROVIDER_KEY' => 'INPUT'
            ]
        ],
        'PSCB_OFD_TAX_DELIVERY' => [
            'NAME' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_DELIVERY_NAME'),
            'DESCRIPTION' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_DELIVERY_DESCR'),
            'SORT' => 10060,
            'GROUP' => Loc::getMessage('DARNEO_PSCB_PAYMENT_GROUP_OFD'),
            'TYPE' => 'SELECT',
            'INPUT' => [
                'TYPE' => 'ENUM',
                'OPTIONS' => [
                    'none' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_ITEM_1'),
                    'vat0' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_ITEM_2'),
                    'vat10' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_ITEM_3'),
                    'vat20' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_ITEM_4'),
                    'vat110' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_ITEM_5'),
                    'vat120' => Loc::getMessage('PSCB_PAYMENT_API_OFD_TAX_ITEM_6'),
                ]
            ],
            'DEFAULT' => [
                'PROVIDER_VALUE' => 'none',
                'PROVIDER_KEY' => 'INPUT'
            ]
        ],
    ],
];
