<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Framework\Code\Reader;

use Magento\Framework\GetParameterClassTrait;
use Magento\Framework\Oauth\Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

/**
 * Class ClassReader
 */
class ClassReader implements ClassReaderInterface
{
    use GetParameterClassTrait;

    /**
     * @var array
     */
    private $parentsCache = [];

    /**
     * Read class constructor signature
     *
     * @param  string $className
     * @return array|null
     * @throws ReflectionException
     */
    public function getConstructor($className)
    {
        $class = new ReflectionClass($className);
        $result = null;
        $constructor = $class->getConstructor();
        if ($constructor) {
            $result = [];
            /** @var $parameter ReflectionParameter */
            foreach ($constructor->getParameters() as $parameter) {
                try {
                    $parameterClass = $this->getParameterClass($parameter);

                    $result[] = [
                        $parameter->getName(),
                        $parameterClass ? $parameterClass->getName() : null,
                        !$parameter->isOptional() && !$parameter->isDefaultValueAvailable(),
                        $this->getReflectionParameterDefaultValue($parameter),
                        $parameter->isVariadic(),
                    ];
                } catch (ReflectionException $e) {
                    $message = sprintf(
                        'Impossible to process constructor argument %s of %s class',
                        $parameter->__toString(),
                        $className
                    );
                    throw new ReflectionException($message, 0, $e);
                }
            }
        }

        return $result;
    }

    /**
     * Get reflection parameter default value
     *
     * @param  ReflectionParameter $parameter
     * @return array|mixed|null
     */
    private function getReflectionParameterDefaultValue(ReflectionParameter $parameter)
    {
        if ($parameter->isVariadic()) {
            return [];
        }

        return $parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null;
    }

    /**
     * Retrieve parent relation information for type in a following format
     * array(
     *     'Parent_Class_Name',
     *     'Interface_1',
     *     'Interface_2',
     *     ...
     * )
     *
     * @param  string $className
     * @return string[]
     */
    public function getParents($className)
    {
        if (isset($this->parentsCache[$className])) {
            return $this->parentsCache[$className];
        }
        //if (is_object($className) ||strstr($className, '\\') || strstr($className, '_')) {
        if (class_exists($className)) {
           $x= 1;
        } else {
            $x= 2;

            //  echo "The variable is not a string.";
        }
        try {
            $parentClass = get_parent_class($className);

    } catch (ReflectionException $e) {
    // Handle the TypeError here, e.g., log an error message or perform some other action.
echo "Caught a TypeError: " . $e->getMessage();
}        if ($parentClass) {
            $result = [];
            $interfaces = class_implements($className);
            if ($interfaces) {
                $parentInterfaces = class_implements($parentClass);
                if ($parentInterfaces) {
                    $result = array_values(array_diff($interfaces, $parentInterfaces));
                } else {
                    $result = array_values($interfaces);
                }
            }
            array_unshift($result, $parentClass);
        } else {
            $result = array_values(class_implements($className));
            if ($result) {
                array_unshift($result, null);
            } else {
                $result = [];
            }
        }

        $this->parentsCache[$className] = $result;

        return $result;
    }

    /**
     * Disable show internals with var_dump
     *
     * @see https://www.php.net/manual/en/language.oop5.magic.php#object.debuginfo
     * @return array
     */
    public function __debugInfo()
    {
        return [];
    }
}
