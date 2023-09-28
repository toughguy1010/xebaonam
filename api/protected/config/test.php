<?php
/**
 * test.php
 *
 * configuration file for backend testing
 */
return CMap::mergeArray(
	require(__DIR__ . '/main.php'),
	array(
		'components' => array(
			'fixture' => array(
				'class' => 'system.test.CDbFixtureManager'
			),
			// Put correct test DB credentials here
			'db' => array(
				'connectionString' => 'mysql:host=127.0.0.1;dbname=utopia',
				'username' => 'root',
				'password' => '',
			),
		)
	)
);
