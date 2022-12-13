<?php

    class MathExpr {
        
        private $expression;

        public function __construct($expression)
        {
            $expression = str_replace(" ", "", $expression);
            $this->expression = str_replace("--", "+", $expression);
        }

        public function getExpression(){
            return $this->expression;
        }

        public function getParsedExpression(){
            $expr = [];
            $pattern = '/(\-[\d.]+)|([\d.]+)|([\+\-\/\*])/'; // regex pattern to extract number, math operators, and parentheses
            preg_match_all(
                $pattern,
                $this->getExpression(),
                $expr  
            );

            return empty($expr) ? [] : $expr[0];

        }

        public function calculate($val1, $val2, $operator){
            if($operator === "+"){
                return $val1 + $val2;
            }
            elseif($operator === "-"){
                return $val1 - $val2;
            }
            elseif($operator === "*"){
                return $val1 * $val2;
            }
            elseif($operator === "/"){
                return $val1 / $val2;
            }
        }

        public function precedence($op1){
            $operators = ["+", "-", "*", "/"];
            return array_search($op1, $operators)?: -1;
        }

        public function evaluate(){
            $operators = new SplStack();
            $numbers = new SplStack();
            
            foreach($this->getParsedExpression() as $expr){
                if(is_numeric($expr)){
                    $numbers->push(floatval($expr));
                }
                else if(in_array($expr, ["+", "-", "*", "/"])){
                    while (!$operators->isEmpty() && $this->precedence($expr) < $this->precedence($operators->top())) {
                        $n1 = $numbers->pop();
                        $n2 = $numbers->pop();
                        $op = $operators->pop();
                        $numbers->push($this->calculate($n1, $n2, $op));
                    }
                    $operators->push($expr);
                }
                elseif("(" === $expr){
                    $operators->push($expr);
                }

                elseif(")" === $expr){
                    $op = $operators->pop();
                    while($op !== "("){
                        $n1 = $numbers->pop();
                        $n2 = $numbers->pop();
                        $numbers->push($this->calculate($n1, $n2, $op));
                        $op = $operators->pop();
                    }
                }
            }

            while(!$operators->isEmpty()){
                $n1 = $numbers->pop();
                $n2 = $numbers->pop();
                $op = $operators->pop();
                $numbers->push($this->calculate($n1, $n2, $op));
            }

            return $numbers->isEmpty() ? 0 : $numbers->pop();
        }
    }
?>