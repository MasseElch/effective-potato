<?php

// Load the fixtures for the tests
passthru(sprintf('php %s/../bin/console doctrine:schema:drop --force --env=test', __DIR__));
passthru(sprintf('php %s/../bin/console doctrine:schema:create --env=test', __DIR__));
passthru(sprintf('echo \'y\n\' | php %s/../bin/console hautelook:fixtures:load --env=test', __DIR__));

require __DIR__.'/../vendor/autoload.php';
