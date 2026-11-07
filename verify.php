<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Hitrov\OciApi;
use Hitrov\OciConfig;

$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->safeLoad();

$config = new OciConfig(
    (string) getenv('OCI_REGION'),
    (string) getenv('OCI_USER_ID'),
    (string) getenv('OCI_TENANCY_ID'),
    (string) getenv('OCI_KEY_FINGERPRINT'),
    (string) getenv('OCI_PRIVATE_KEY_FILENAME'),
    getenv('OCI_AVAILABILITY_DOMAIN') ?: null,
    '',
    ''
);

try {
    $instances = (new OciApi())->getInstances($config);
} catch (Throwable $e) {
    fwrite(STDERR, "OCI verification failed: {$e->getMessage()}\n");
    exit(1);
}

printf("OCI verification succeeded: %d instance(s) visible in tenancy\n", count($instances));
