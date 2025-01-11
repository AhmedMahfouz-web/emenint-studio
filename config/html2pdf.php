<?php

return [
    'mode'                  => 'en',
    'format'                => 'A4',
    'defaultFont'           => 'Arial',
    'marginLeft'            => 10,
    'marginRight'           => 10,
    'marginTop'             => 10,
    'marginBottom'          => 10,
    'orientation'           => 'P',
    'title'                 => 'PDF Document',
    'author'               => 'Eminent Studio',
    'watermark'            => '',
    'showWatermark'        => false,
    'watermarkFont'        => 'Arial',
    'displayMode'          => 'fullpage',
    'watermarkTextAlpha'   => 0.1,
    'html2pdf' => [
        'html2pdf_params' => [
            'locale'        => 'en',
            'encoding'      => 'UTF-8',
            'margin_left'   => 10,
            'margin_right'  => 10,
            'margin_top'    => 10,
            'margin_bottom' => 10,
            'margin_header' => 0,
            'margin_footer' => 0,
            'orientation'   => 'P',
        ],
    ],
];
