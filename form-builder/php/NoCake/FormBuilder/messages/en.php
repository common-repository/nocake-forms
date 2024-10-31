<?php

return [
    'checkbox' => [
        'checkbox' => [
            'required' => 'Select at least one option.',
            'bad_value' => 'Select at least one option.'
        ]
    ],
    'radio' => [
        'radio' => [
            'required' => 'Select at least one option.'
        ]
    ],
    'select' => [
        'select' => [
            'required' => 'Select at least one option.'
        ]
    ],
    'textArea' => [
	    'any' => [
	    	'required' => 'Enter value.',
	    	'too_low' => 'The value cannot be shorter than "%d" characters.',
	    	'too_high' => 'The value cannot be longer than "%d" characters.'
	    ]
    ],
    'textInput' => [
        'any' => [
            'required' => 'Enter value.',
            'too_low' => 'The value cannot be shorter than "%d" characters.',
            'too_high' => 'The value cannot be longer than "%d" characters.'
        ],
        'int' => [
            'required' => 'Enter value.',
            'not_int' => 'This field can contain only integers.',
            'too_low' => 'Integer cannot be lower then "%d".',
            'too_high' => 'Integer cannot be higher then "%d".'
        ],
        'num' => [
            'required' => 'Enter value.',
            'not_num' => 'This field can contain only numbers.',
            'too_low' => 'Number cannot be lower then "%d".',
            'too_high' => 'Number cannot be higher then "%d".'
        ],
        'decimal' => [
            'required' => 'Enter value.',
            'not_decimal' => 'This field can contain only decimal numbers.',
            'too_low' => 'Number cannot be lower then "%d".',
            'too_high' => 'Number cannot be higher then "%d".',
            'too_low_decimal' => 'Number must have at least "%d" integers after comma.',
            'too_high_decimal' => 'Number must not have more then "%d" integers after comma.'
        ],
        'firstName' => [
            'required' => 'Enter value.',
            'not_first_name' => 'Provided first name have forbidden characters.',
            'too_short' => 'First name must have at least 2 characters.',
            'too_long' => 'First name cannot be longer then 40 characters.'
        ],
        'lastName' => [
            'required' => 'Enter value.',
            'not_last_name' => 'Provided last name have forbidden characters.',
            'too_short' => 'Last name must have at least 2 characters.',
            'too_long' => 'Last name cannot be longer then 40 characters.'
        ],
        'email' => [
            'required' => 'Enter value.',
            'not_email' => 'It is not a valid email address.'
        ],
        'phone' => [
	        'required' => 'Enter value.',
	        'not_phone' => 'It is not a valid phone number.'
        ],
        'zipCode' => [
	        'required' => 'Enter value.',
	        'not_zip_code' => 'It is not a valid zip code.'
        ],
        'url' => [
            'required' => 'Enter value.',
            'not_url' => 'It is not a valid url address.'
        ]
    ],
    'file' => [
        'file' => [
            'required' => 'Select a file.',
            'file_format' => 'Type of the selected file is unsupported.',
            'exceeded_filesize_limit' => 'The file is too large.',
        ]
    ]
];
