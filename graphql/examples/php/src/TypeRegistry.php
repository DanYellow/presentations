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
        // return $this->book ?: ($this->book = new BookType($this));
        return self::$book ?: (self::$book = new BookType());
    }

    public static function author()
    {
        // return $this->author ?: ($this->author = new AuthorType($this));
        return self::$author ?: (self::$author = new AuthorType());
    }

    public static function editor()
    {
        // return $this->editor ?: ($this->editor = new EditorType($this));
        return self::$editor ?: (self::$editor = new EditorType());
    }
}
