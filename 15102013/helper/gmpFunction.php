<?php
function gmpCong($a,$b){
    $a=gmp_init($a);
    $b=gmp_init($b);
    $c=gmp_add($a,$b);
    return gmp_strval($c);
}

function gmpTru($a,$b){
    $a=gmp_init($a);
    $b=gmp_init($b);
    $c=gmp_sub($a,$b);
    return gmp_strval($c);
}
function gmpSosanh($a,$b){
    $a=gmp_init($a);
    $b=gmp_init($b);
    $c=gmp_cmp($a,$b);
    return gmp_strval($c);
}

function gmpNhan($a,$b){
    $a=gmp_init($a);
    $b=gmp_init($b);
    $c=gmp_mul($a,$b);
    return gmp_strval($c);
}

function gmpChia($a,$b){
    $a=gmp_init($a);
    $b=gmp_init($b);
    $c=gmp_div($a,$b);
    return gmp_strval($c);
}