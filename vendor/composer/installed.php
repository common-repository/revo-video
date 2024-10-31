<?php return array(
    'root' => array(
        'name' => 'revo-video/revo-video',
        'pretty_version' => 'trunk',
        'version' => 'dev-trunk',
        'reference' => NULL,
        'type' => 'project',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'curl/curl' => array(
            'pretty_version' => '2.5.0',
            'version' => '2.5.0.0',
            'reference' => 'c4f8799c471e43b7c782c77d5c6e178d0465e210',
            'type' => 'library',
            'install_path' => __DIR__ . '/../curl/curl',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'revo-video/revo-video' => array(
            'pretty_version' => 'trunk',
            'version' => 'dev-trunk',
            'reference' => NULL,
            'type' => 'project',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
    ),
);
