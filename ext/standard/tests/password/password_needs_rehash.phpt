--TEST--
Test normal operation of password_needs_rehash()
--FILE--
<?php
//-=-=-=-

// Invalid Hash, always rehash
var_dump(password_needs_rehash('', PASSWORD_BCRYPT));

// Valid, as it's an unknown algorithm
var_dump(password_needs_rehash('', 0));

// Valid with cost the same
var_dump(password_needs_rehash('$2y$10$MTIzNDU2Nzg5MDEyMzQ1Nej0NmcAWSLR.oP7XOR9HD/vjUuOj100y', PASSWORD_BCRYPT, array('cost' => 10)));

// Valid with cost the same, additional params
var_dump(password_needs_rehash('$2y$10$MTIzNDU2Nzg5MDEyMzQ1Nej0NmcAWSLR.oP7XOR9HD/vjUuOj100y', PASSWORD_BCRYPT, array('cost' => 10, 'foo' => 3)));

// Invalid, different (lower) cost
var_dump(password_needs_rehash('$2y$10$MTIzNDU2Nzg5MDEyMzQ1Nej0NmcAWSLR.oP7XOR9HD/vjUuOj100y', PASSWORD_BCRYPT, array('cost' => 0)));

// Invalid, different (higher) cost
var_dump(password_needs_rehash('$2y$10$MTIzNDU2Nzg5MDEyMzQ1Nej0NmcAWSLR.oP7XOR9HD/vjUuOj100y', PASSWORD_BCRYPT, array('cost' => 11)));

// Valid with cost the default
$cost = str_pad(PASSWORD_BCRYPT_DEFAULT_COST, 2, '0', STR_PAD_LEFT);
var_dump(password_needs_rehash('$2y$'.$cost.'$MTIzNDU2Nzg5MDEyMzQ1Nej0NmcAWSLR.oP7XOR9HD/vjUuOj100y', PASSWORD_BCRYPT));

// Should Issue Needs Rehash, Since Foo is cast to 0...
var_dump(password_needs_rehash('$2y$10$MTIzNDU2Nzg5MDEyMzQ1Nej0NmcAWSLR.oP7XOR9HD/vjUuOj100y', PASSWORD_BCRYPT, array('cost' => 'foo')));

var_dump(password_needs_rehash('$argon2i$v=19$m=65536,t=3,p=1$YkprUktYN0lHQTd2bWRFeA$79aA+6IvgclpDAJVoezProlqzIPy7do/P0sBDXS9Nn0', PASSWORD_ARGON2, ['m_cost' => 1<<17]));
var_dump(password_needs_rehash('$argon2i$v=19$m=65536,t=3,p=1$YkprUktYN0lHQTd2bWRFeA$79aA+6IvgclpDAJVoezProlqzIPy7do/P0sBDXS9Nn0', PASSWORD_ARGON2, ['t_cost' => 2]));
var_dump(password_needs_rehash('$argon2i$v=19$m=65536,t=3,p=1$YkprUktYN0lHQTd2bWRFeA$79aA+6IvgclpDAJVoezProlqzIPy7do/P0sBDXS9Nn0', PASSWORD_ARGON2, ['threads' => 2]));
echo "OK!";
?>
--EXPECT--
bool(true)
bool(false)
bool(false)
bool(false)
bool(true)
bool(true)
bool(false)
bool(true)
bool(true)
bool(true)
bool(true)
OK!
