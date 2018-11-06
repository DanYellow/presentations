<?php

namespace App;

use App\QueryTypes\BookType;
use App\QueryTypes\AuthorType;
use App\QueryTypes\EditorType;

class TypeRegistry
{
    private static $book;
    private static $author;
    private static $editor;

    public static function book()
    {
        return self::$book ?: (self::$book = new BookType());
    }

    public static function author()
    {
        return self::$author ?: (self::$author = new AuthorType());
    }

    public static function editor()
    {
        return self::$editor ?: (self::$editor = new EditorType());
    }
}