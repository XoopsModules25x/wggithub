<?php

namespace XoopsModules\Wggithub\Github;


/**
 * Undefined member access check. Stolen from Nette\Object (http://nette.org).
 */
abstract class Sanity
{
    /**
     * @param $name
     */
    public function & __get($name)
    {
        throw new LogicException('Cannot read an undeclared property ' . \get_class($this) . "::\$$name.");
    }


    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        throw new LogicException('Cannot write to an undeclared property ' . \get_class($this) . "::\$$name.");
    }

}
