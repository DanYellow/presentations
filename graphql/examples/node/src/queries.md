```graphql
query GetAllBooks {
  books {
    id
    title
    releaseDate
    coverImage
    summary
    author {
      lastName
      firstName
    }
    editor {
      name
    }
  }
}

query GetAllRicksBooks {
  getRicksBooks: books(author: { firstName: "Rick", lastName: "null" }) {
    id
    title
    releaseDate
    coverImage
    summary
    author {
      lastName
      firstName
    }
    editor {
      name
    }
  }
}

query GetBookByID {
  book(id: 1) {
    id
    title
    author {
      firstName
      lastName
    }
  }
}

mutation CreateBook(
  $book: BookInput
  $author: AuthorInput
  $editor: EditorInput
) {
  createBook(book: $book, author: $author, editor: $editor) {
    id
    title
    summary
    releaseDate
    author {
      firstName
      lastName
    }
    editor {
      name
    }
  }
}

query GetAllAuthors {
  authors {
    id
    lastName
    firstName
    editors {
      ...editorFields
    }
  }
}

query GetAuthorByID {
  author(id: 1) {
    id
    lastName
    firstName
    editors {
      ...editorFields
    }
  }
}

mutation CreateAuthor($books: [BookInput], $author: AuthorInput) {
  createAuthor(books: $books, author: $author) {
    id
    firstName
    lastName
    books {
      title
    }
    editors {
      name
    }
  }
}

mutation AddEditorToAuthor($editor: EditorInput, $author: AuthorInput) {
  addEditorToAuthor(editor: $editor, author: $author) {
    id
    firstName
    lastName
    books {
      title
    }
    editors {
      name
    }
  }
}

mutation DeleteAuthor {
  deleteAuthor(id: 10)
}

query GetAllEditors {
  editors {
    id
    name
    authors {
      id
      lastName
      firstName
      books {
        title
      }
    }
    books {
      title
    }
  }
}

query GetEditorByID {
  editor(id: 1) {
    id
    ...editorFields
  }
}

mutation CreateEditor($authors: [AuthorInput], $editor: EditorInput) {
  createEditor(authors: $authors, editor: $editor) {
    id
    name
    authors {
      firstName
      lastName
    }
  }
}

fragment editorFields on Editor {
  id
  name
  books {
    id
  }
  authors {
    id
  }
}
```

### Variables

#### CreateAuthor

($books: [BookInput], $author: AuthorInput, $editors: [EditorInput])

```js
{
  "author": {
    "firstName": "Aldous",
    "lastName": "Huxley"
  },
  "books": [
    {
      "title": "Brave New World",
      "summary": "The novel opens in the World State city of London in AF (After Ford) 632 (AD 2540 in the Gregorian calendar), where citizens are engineered through artificial wombs and childhood indoctrination programmes into predetermined classes (or castes) based on intelligence and labour. - Wikipedia",
      "editor": {
        "name": "Chatto & Windus"
      }
    }
  ]
}
```

#### AddEditorToAuthor

```js
{
   "author": {
    "firstName": "Aldous",
    "lastName": "Huxley"
  },
  "editor": {
    "name": "Hello world"
  }
}
```
