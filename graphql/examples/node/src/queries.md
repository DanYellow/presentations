```js
query GetBook {
  getBook(id: "c1bae59aa242f504efc8") {
    id
  }
}

query GetBooks {
  getBooks {
    id,
    title,
    author {
      id,
      firstName
    }
  }
}

mutation CreateBook($book: BookInput, $author: AuthorInput) {
  createBook(book: $book, author: $author) {
    id
    title
    summary,
    author {
      firstName
      lastName
      editor {
		name
      }

    }
  }
}
```

```
{
  "book": {
    "title": "The catcher in the rye",
    "summary": "Can make you a killer... :/",
    "author": {
      "firstName": "Jerome",
      "lastName": "Salinger"
    },
    "editor": {
      "name": "Night books"
    }
  }
}
```
