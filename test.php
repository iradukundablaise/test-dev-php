<?php

    require_once 'MathExpr.php';

    $ex1 = "3.5+(3*6+(2*2))";
    $ex2 = "3*2+5";
    $ex3 = "1-(-5)";
    $expr = new MathExpr($ex1);
    $result = $expr->evaluate();
    echo $expr->getExpression()." = $result \n";
?>