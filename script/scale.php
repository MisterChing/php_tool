<?php
require 'init.php';

echo "\nbcmath\n";
echo "exact 1.234 + 5 = 6.234\n";
echo sprintf("1.234 + 5 = %s with 1 scale digits\n", BcmathUtils::add('1.234', 5, 1));
echo sprintf("1.234 + 5 = %s with 2 scale digits\n", BcmathUtils::add('1.234', 5, 2));
echo sprintf("1.234 + 5 = %s with 3 scale digits\n", BcmathUtils::add(1.234, 5, 3));
echo "\n";

echo "exact 1.234 - 5 = -3.766\n";
echo sprintf("1.234 - 5 = %s with 1 scale digits\n", BcmathUtils::sub('1.234', 5, 1));
echo sprintf("1.234 - 5 = %s with 2 scale digits\n", BcmathUtils::sub('1.234', 5, 2));
echo sprintf("1.234 - 5 = %s with 3 scale digits\n", BcmathUtils::sub(1.234, 5, 3));
echo "\n";

echo "exact 123.398 * 2 = 246.796\n";
echo sprintf("123.398 * 2 = %s with 1 scale digits\n", BcmathUtils::mul('123.398', 2, 1));
echo sprintf("123.398 * 2 = %s with 2 scale digits\n", BcmathUtils::mul('123.398', 2, 2));
echo sprintf("123.398 * 2 = %s with 3 scale digits\n", BcmathUtils::mul(123.398, 2, 3));
echo "\n";

echo "exact 105 / 6.55957 = 16.0071468\n";
echo sprintf("105 / 5 = %s with 1 scale digits\n", BcmathUtils::div('105', 6.55957, 1));
echo sprintf("105 / 5 = %s with 2 scale digits\n", BcmathUtils::div('105', 6.55957, 2));
echo sprintf("105 / 5 = %s with 3 scale digits\n", BcmathUtils::div(105, 6.55957, 3));
echo sprintf("105 / 5 = %s with 5 scale digits\n", BcmathUtils::div(105, 6.55957, 5));
echo "\n";

echo "exact 4.2 ** 3 = 74.088\n";
echo sprintf("4.2 ** 3 = %s with 1 scale digits\n", BcmathUtils::pow('4.2', 3, 1));
echo sprintf("4.2 ** 3 = %s with 2 scale digits\n", BcmathUtils::pow('4.2', 3, 2));
echo sprintf("4.2 ** 3 = %s with 3 scale digits\n", BcmathUtils::pow(4.2, 3, 3));
echo "\n";

echo "exact 4 开平方 = 2\n";
echo sprintf("4 sqrt = %s with 1 scale digits\n", BcmathUtils::sqrt('4', 1));
echo sprintf("4 sqrt = %s with 2 scale digits\n", BcmathUtils::sqrt('4', 2));
echo sprintf("4 sqrt = %s with 3 scale digits\n", BcmathUtils::sqrt('4', 3));
echo sprintf("4 sqrt = %s with 4 scale digits\n", BcmathUtils::sqrt('4', 4));
echo "\n";

echo "float problem in php\n";
echo sprintf("intval(0.57 * 100) = %d\n", intval(0.57 * 100));
echo sprintf("intval(bcmul(0.57, 100)) = %d\n", (int)BcmathUtils::mul(0.57, 100));
echo "\n";













