<?php
require_once './Rsa.php';

$primes = new Primes();
$p = $primes->findRandomPrime();
$q = $primes->findRandomPrime();

$rsa = new Rsa($p, $q);
$publicKey = $rsa->getPublicKey();
$privateKey = $rsa->getPrivateKey();

echo json_encode([
    'p' => $p,
    'q' => $q,
    'public_key' => $publicKey,
    'private_key' => $privateKey
]);