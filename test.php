<?php

    require_once 'MathExpr.php';

    $ex1 = "6+-(4)";
    $ex2 = "3*2+5";
    $ex3 = "1-(-5)";
    $expr = new MathExpr($ex2);
    $result = $expr->evaluate();
    echo $expr->getExpression()." = $result \n";
?>