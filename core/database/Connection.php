<?php

class Connection
{
    // static - make posibility to call the method without creating new object of this class.
    // e.g. you can write Connection::make(); to call this method
    public static function make($config)
    {
        try {
            return new PDO(
                $config['connection'] . ';dbname=' . $config['name'],
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}