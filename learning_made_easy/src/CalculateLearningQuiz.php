<?php


namespace App;


use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\VarDumper\Exception\ThrowingCasterException;

class CalculateLearningQuiz
{

    private array $reflector;

    private array $intuitive;

    private array $verbal;

    private array $global;

    private array $mainArray;
    private int $a;
    private int $b;


    public function __construct($mainArray)
    {
        $this->mainArray = $mainArray;
    }

    public function validate(){
        foreach($this->mainArray as $value => $item){
            if (empty($item)) {
                throw new \Exception('You never finished the quiz   ');
            }
        }
    }

    public function trigger(){
        // remove q from key
        $this->validate();
        $keys = str_replace( 'q', '', array_keys( $this->mainArray ) );
        $results = array_combine( $keys, array_values( $this->mainArray ) );

        $this->reflector = array_filter($results, function($k) {
            return $k  % 4 == 1;
        }, ARRAY_FILTER_USE_KEY);

        $this->intuitive = array_filter($results, function($k) {
            return $k  % 4 == 2;
        }, ARRAY_FILTER_USE_KEY);

        $this->verbal = array_filter($results, function($k) {
            return $k  % 4 == 3;
        }, ARRAY_FILTER_USE_KEY);

        $this->global = array_filter($results, function($k) {
            return $k  % 4 == 0;
        }, ARRAY_FILTER_USE_KEY);

        $globalCalculated = $this->calculateAandB($this->global);
        $global = $this->findPreference($globalCalculated, 'global');

        $verbalCalculated = $this->calculateAandB($this->verbal);
        $verbal = $this->findPreference($verbalCalculated, 'verbal');

        $intuitiveCalculated = $this->calculateAandB($this->intuitive);
        $intuitive = $this->findPreference($intuitiveCalculated, 'intuitive');

        $reflectorCalculated = $this->calculateAandB($this->reflector);
        $reflector = $this->findPreference($reflectorCalculated, 'reflector');

        $now = $this->compareHighestPreference($global, $intuitive, $verbal, $reflector);

        arsort($now, SORT_REGULAR);

        return $now;
    }


    public function findPreference($array, $type){
        $largest = max($this->a, $this->b) - min($this->a, $this->b);
        $array[$type] = $largest;
        return $array;
    }

    public function compareHighestPreference($array, $array1, $array2, $array3){
        $first = array_slice($array, -1, 1, true);
        $second = array_slice($array1, -1, 1, true);
        $third = array_slice($array2, -1, 1, true);
        $forth = array_slice($array3, -1, 1, true);

        $forth = array_merge($first,$second, $third, $forth);
        return $forth;
    }


    public function calculateAandB($array){
        $this->a = 0;
        $this->b = 0;
        foreach($array as $row => $value){
            switch($value){
                case 'a':
                    $this->a++;
                    break;
                case 'b':
                    $this->b++;
                    break;
            }
        }
        $array['answerA'] = $this->a;
        $array['answerb'] = $this->b;


        return $array;
    }


}