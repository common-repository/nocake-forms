<?php

return [
    'checkbox' => [
        'checkbox' => [
            'required' => 'Zaznacz przynajmniej jedną z opcji.',
            'bad_value' => 'Zaznacz przynajmniej jedną z opcji.'
        ]
    ],
    'radio' => [
        'radio' => [
            'required' => 'Zaznacz jedną z opcji.'
        ]
    ],
    'select' => [
        'select' => [
            'required' => 'Wybierz jedną z pozycji.'
        ]
    ],

    'textArea' => [
	    'any' => [
		    'required' => 'Wprowadź wartość.',
		    'too_low' => 'Ilość znaków nie może być mniejsza niż "%d".',
		    'too_high' => 'Ilość znaków nie może być większa niż "%d".'
	    ]
    ],
    'textInput' => [
	    'any' => [
		    'required' => 'Wprowadź wartość.',
		    'too_low' => 'Ilość znaków nie może być mniejsza niż "%d".',
		    'too_high' => 'Ilość znaków nie może być większa niż "%d".'
	    ],
        'int' => [
            'required' => 'Wprowadź wartość.',
            'not_int' => 'To pole przyjmuje tylko cyfry.',
            'too_low' => 'Wartość tego pola nie może być mniejsza niż "%d".',
            'too_high' => 'Wartość tego pola nie może być większa niż "%d".'
        ],
        'num' => [
            'required' => 'Wprowadź wartość.',
            'not_num' => 'To pole przyjmuje tylko liczby.',
            'too_low' => 'Wartość tego pola nie może być mniejsza niż "%d".',
            'too_high' => 'Wartość tego pola nie może być większa niż "%d".'
        ],
        'decimal' => [
            'required' => 'Wprowadź wartość.',
            'not_decimal' => 'To pole przyjmuje tylko liczby zmiennoprzecinkowe.',
            'too_low' => 'Wartość tego pola nie może być mniejsza niż "%d".',
            'too_high' => 'Wartość tego pola nie może być większa niż "%d".',
            'too_low_decimal' => 'Liczba musi mieć przynajmniej "%d" miejsca po przecinku.',
            'too_high_decimal' => 'Liczba musi mieć maksymalnie "%d" miejsca po przecinku.'
        ],
        'firstName' => [
            'required' => 'Wprowadź wartość.',
            'not_first_name' => 'Podane imię zawiera niedozwolone znaki.',
            'too_short' => 'Imię nie może mieć mniej niż 2 znaki.',
            'too_long' => 'Imię nie może mieć więcej niż 40 znaków.'
        ],
        'lastName' => [
            'required' => 'Podaj nazwisko.',
            'not_last_name' => 'Podane nazwisko zawiera niedozwolone znaki.',
            'too_short' => 'Nazwisko nie może mieć mniej niż 2 znaki.',
            'too_long' => 'Nazwisko nie może mieć więcej niż 40 znaków.'
        ],
        'email' => [
            'required' => 'Wprowadź adres email.',
            'not_email' => 'To nie jest prawidłowy adres email.'
        ],
	    'phone' => [
		    'required' => 'Wprowadź telefon.',
		    'not_phone' => 'To nie jest poprawny numer telefonu.'
	    ],
	    'zipCode' => [
		    'required' => 'Wprowadź kod pocztowy.',
		    'not_zip_code' => 'To nie jest poprawny kod pocztowy.'
	    ],
        'url' => [
            'required' => 'Wprowadź adres url.',
            'not_url' => 'To nie jest prawidłowy adres url.'
        ]
    ],
    'file' => [
        'file' => [
            'required' => 'Wybierz plik.',
            'file_format' => 'Ten typ pliku jest niedozwolony.',
            'exceeded_filesize_limit' => 'Plik jest za duży.',
        ]
    ]
];
