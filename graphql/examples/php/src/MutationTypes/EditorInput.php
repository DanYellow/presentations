<?php

namespace App\MutationTypes;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

use App\TypeRegistry;


class EditorInput extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'description' => "Creates an editor",
            'fields' => [
                'name' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => "Editor's name",
                ],
                'photo' => Type::string(),
            ],
        ];
        parent::__construct($config);
    }
}