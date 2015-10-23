<?php
$EM_CONF[$_EXTKEY] = array(
    'title' => 'Mr.Base-Configuration',
    'description' => 'This Extension adds the Function to use an ext_configuration.php File.',
    'category' => 'misc',
    'version' => '0.1.0',
    'author' => 'Sascha Heilmeier',
    'author_email' => 'sheilmeier@gmail.com',
    'author_company' => '',
    'shy' => '',
    'priority' => '',
    'module' => '',
    'state' => 'test',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 0,
    'lockType' => '',
	'constraints' => 
	array (
		'depends' => array (
			'typo3' => '6.2.0-7.4.99',
        ),
        'conflicts' => array(
        ),
        'suggests' => array(
        ),
    ),
);