<?php

namespace App\Helper;

use Illuminate\Support\Facades\Hash;

class HashPassword
{
    public static function verify(string $password, string $passwordHash): bool
    {
        $pieces = explode('$', $passwordHash);

        if (count($pieces) !== 4) {
            throw new \Exception("Illegal hash format");
        }

        list($header, $iter, $salt, $hash) = $pieces;

        if (preg_match('#^pbkdf2_([a-z0-9A-Z]+)$#', $header, $m)) {
            $algo = $m[1];
        } else {
            throw new \Exception(sprintf("Bad header (%s)", $header));
        }

        if (!in_array($algo, hash_algos())) {
            throw new \Exception(sprintf("Illegal hash algorithm (%s)", $algo));
        }

        // $calc = Hash::make($password, [
        //     'rounds' => (int)$iter,
        //     'salt' => $salt,
        //     'algorithm' => 'pbkdf2-' . strtolower($algo),
        // ]);

        // return Hash::check(substr($calc, 7), base64_decode($hash));

        $calc = hash_pbkdf2(
            $algo,
            $password,
            $salt,
            (int) $iter,
            32,
            true
        );

        return hash_equals($calc, base64_decode($hash));
    }

    public static function create(string $password)
    {
        $salt = bin2hex(random_bytes(11));

        $iterations = 390000;

        $hash_length = 32;

        // $hash = Hash::make($password, [
        //     'rounds' => $iterations,
        //     'salt' => $salt,
        //     'algorithm' => 'pbkdf2-sha256',
        // ]);

        // $formatted_hash = 'pbkdf2_sha256$' . $iterations . '$' . $salt . '$' . substr($hash, 7);

        $hash = base64_encode(
			hash_pbkdf2(
				'sha256',
				$password,
				$salt,
				$iterations,
				$hash_length,
				true
			)
		);

        $formatted_hash = 'pbkdf2_sha256$' . $iterations . '$' . $salt . '$' . $hash;

        return $formatted_hash;
    }
}