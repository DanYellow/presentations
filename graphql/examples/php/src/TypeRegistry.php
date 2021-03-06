<?php

namespace App;

use App\QueryTypes\BookType;
use App\QueryTypes\AuthorType;
use App\QueryTypes\EditorType;

use App\MutationTypes\AuthorInput;
use App\MutationTypes\BookInput;
use App\MutationTypes\EditorInput;

class TypeRegistry
{
    private static $book;
    private static $author;
    private static $editor;

    private static $bookInput;
    private static $authorInput;
    private static $editorInput;

    public static function book()
    {
        return self::$book ?: (self::$book = new BookType());
    }

    public static function bookInput()
    {
        return self::$bookInput ?: (self::$bookInput = new BookInput());
    }

    public static function author()
    {
        return self::$author ?: (self::$author = new AuthorType());
    }

    public static function authorInput()
    {
        return self::$authorInput ?: (self::$authorInput = new AuthorInput());
    }

    public static function editor()
    {
        return self::$editor ?: (self::$editor = new EditorType());
    }

    public static function editorInput()
    {
        return self::$editorInput ?: (self::$editorInput = new EditorInput());
    }
}
