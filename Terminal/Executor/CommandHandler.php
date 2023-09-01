<?php

namespace Rcngl\Console\Executor;

use Rcngl\Console\Output\WriteLine;
use ReflectionFunction;

class CommandHandler
{
    private $handler;

    private $method;

    public function __construct($callback, $method) {

        $this->handler = $callback;
        $this->method = $method;

        if (!$this->isCallable()) {
            $this->ClassHadlerMethod();
        }else{
            $this->CallableHandler();
        }

    }

    /**
     * @return bool - true if callable, otherwise false
     */
    public function isCallable() : bool {
        return (bool) is_callable($this->handler);
    }

    /**
     * @var $reflectionClass - Reflection of callback class
     */
    private $reflectionClass;


    /**
     * @param $reflection - tells wheather return as reflection or instance
     * @return class instance or reflection
     */
    private function instantiateClass($reflection = false)
    {
        if (!class_exists($this->handler)) {
            WriteLine::Println("Class instantiation failed.",'red');
            return null;
        }

        $reflectionClass = new \ReflectionClass($this->handler);

        if ($reflection) {
            return $reflectionClass;
        }

        // Check if the class can be instantiated
        if ($reflectionClass->isInstantiable()) {
            return $reflectionClass->newInstance();
        }

        WriteLine::Println("Class instantiation failed.",'red');
        return null;
    }


    private $callableMethodParameter ; 
    private function CallableHandler() 
    {
        $callableReflection = new ReflectionFunction($this->handler);

        $this->callableMethodParameter = $callableReflection->getParameters();
    }


  
    /**
     * @var $reflectionMethod
     */
    private $reflectionClassMethod;

    private $reflectionClassMethodParameter;

   

    private function ClassHadlerMethod() {

        $this->reflectionClass =$instamce = $this->instantiateClass();
        
         $reflection = new \ReflectionClass($instamce);
        if (
            $reflection->hasMethod($this->method) && 
            $reflection->getMethod($this->method)->isPublic()
        ){

            $this->reflectionClassMethod = $classMethod = $reflection->getMethod($this->method);
            $this->reflectionClassMethodParameter = $classMethod->getParameters();
        }else{
            $string = "Undefined public method \"%s\" in class %s";
            WriteLine::Println(sprintf($string,(string) $this->method,$this->handler),'red');
            die();
        }

    }

    private function callFunction($parameters = array()) {
        return call_user_func_array($this->handler, $parameters);
    }


    public function Execute($params) : mixed {
        $param = [];
        $param = array_merge($param, $params);
        if ($this->isCallable()) {
            return $this->callFunction($param);
        }else{
            
            return $this
                ->reflectionClassMethod
                ->invokeArgs(
                    $this->reflectionClass, $param
                );
        }

    }


    public function getHadler()
    {
        return $this->handler;   
    }

    public function getMethod()
    {
        return $this->method;   
    }

    public function getCallbackParameters()
    {
        if ($this->isCallable()) {
            return $this->callableMethodParameter;
        }
        return $this->reflectionClassMethodParameter;   
    }

    public function hasParameter() : bool {
        if ($this->isCallable()) {
            return (count($this->callableMethodParameter) > 0) ? true : false;
        }
        return (count($this->reflectionClassMethodParameter) > 0) ? true : false;
    }


}
