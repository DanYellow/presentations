```
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
      ...editorFields
    }
  }
}

query GetBookByID {
  book(id: 3) {
    id
    title
    author {
      firstName
    }
  }
}

mutation CreateBook($book: BookInput, $author: AuthorInput, $editor: EditorInput) {
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
  author(id: 3) {
    id
    lastName
    firstName
    editors {
      ...editorFields
    }
  }
}

mutation CreateAuthor($books: [BookInput], $author: AuthorInput, $editors: [EditorInput]) {
  createAuthor(books: $books, author: $author, editors: $editors) {
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

query GetAllEditors {
  editors {
    id
    name
    authors {
      id
      lastName
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
