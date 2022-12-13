<?php

    require_once 'MathExpr.php';

    $ex1 = "3.5+(3*6+(2*2))";
    $ex2 = "3*2+5";
    $ex1 = "1--1";
    $expr = new MathExpr($ex1);
    $expr->evaluate();
?>