<?php

return array(
	'twig.path'       => APP_PATH_SRC,
    'twig.class_path' => APP_PATH_VENDOR . '/Twig/lib',
    'twig.options'    => array(
        'cache'       => APP_PATH_CACHE . '/twig.cache'
    ),
);