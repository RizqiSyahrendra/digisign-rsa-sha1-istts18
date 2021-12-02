<?php
class Rsa {
    private $p, $q;
    private $k, $ttn;
     
    private $n, $e; //untuk public key
    private $d; //untuk private key

    public function __construct($p, $q)
    {
        $this->p = $p;
        $this->q = $q;
        $this->k = 2;
        $this->ttn = ($this->p - 1) * ($this->q - 1);

        $this->generatePublicKey();
        $this->generatePrivateKey();
    }

    private function generatePublicKey()
    {
        $this->n = $this->p * $this->q;

        $e = 2;
        $ttn = $this->ttn;

        //e koprima dengan toitent n
        while ($e) {
            if ($this->cprm($e, $ttn) == 1) {
                break;
            }
            else {
                $e++;
            }
        }

        $this->e = $e;
    }

    private function generatePrivateKey()
    {
        $this->d = ($this->k * $this->ttn + 1) / $this->e;
        while(!is_int($this->d)){
            $this->k ++;
            $this->d = ($this->k * $this->ttn + 1) / $this->e;
        }
    }

    private function cprm($x, $y) 
    {
        do {
            $temp = $x % $y;
            if ($temp == 0) {
                return $y;
            }

            $x = $y;
            $y = $temp;
        } while (TRUE);
    }

    public function getPublicKey()
    {
        return $this->e. ','. $this->n;
    }

    public function getPrivateKey()
    {
        return $this->d. ','. $this->n;
    }

    public static function encrypt($plainteks, $publicKey)
    {
        $publicKey = explode(",", $publicKey);
        $e = $publicKey[0];
        $n = $publicKey[1];

        $chars = str_split($plainteks);
        $encrypted = array_map(function($chr) use($e, $n) {
            $m = ord($chr); //convert char ke ascii
            $c = bcmod(bcpow($m, $e), $n); 
            return $c;
        }, $chars);

        $hexaDecimal = array_map(function($chp) {
            $h = dechex($chp); //convert decimal to hexadecimal
            return $h;
        }, $encrypted);
        $chiperteksinHexa = implode(" ", $hexaDecimal);
        return $chiperteksinHexa;
    }

    public static function decrypt($hexaDecimal, $privateKey)
    {
        $privateKey = explode(",", $privateKey);
        $d = $privateKey[0];
        $n = $privateKey[1];

	    $hexas = explode(" ", $hexaDecimal);
        $chiperArr = array_map(function($hex) {
            $h = hexdec($hex); //convert hexadecimal to decimal
            return $h;
        }, $hexas);

        $decrypted = array_map(function($c) use ($d, $n) {
            $m = bcmod(bcpow($c, $d), $n);
            return chr($m);
        }, $chiperArr);

        $plainteks = implode("", $decrypted);
        return $plainteks;
    }
}

class Primes {
    public function findRandomPrime()
    {
        $min = 2;
        $max = 150;
        for ($i=rand($min, $max); $i < $max; $i++) {
            if ($this->isPrime($i)) {
                return $i;
            }
        }
    }

    public function isPrime($num){
        /**
         * if the number is divisible by two, then it's not prime and it's no longer
         * needed to check other even numbers
         */
        if($num % 2 == 0 || $num == "") {
            return false;
        }
        /**
         * Checks the odd numbers. If any of them is a factor, then it returns false.
         * The sqrt can be an aproximation, hence just for the sake of
         * security, one rounds it to the next highest integer value.
         */
        for($i = 3; $i <= ceil(sqrt($num)); $i = $i + 2) {
            if($num % $i == 0)
                return false;
        }

        return true;
    }
}
