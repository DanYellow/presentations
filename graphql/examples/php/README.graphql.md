```

# mutation CreateAuthor ($author: AuthorInput!) {
#   createAuthor: createAuthor(author: $author) {
#     ...AuthorFragment
#   }
# }

# mutation DeleteAuthor {
#   deleteAuthor: deleteAuthor(id: 4) {
#     ...AuthorFragment
#   }
# }

mutation CreateEditor {
  createEditor(
    editor: {
      name: "De la nuit",
      photo: ""
      
    }
  ) {
    name
    photo
    creationDate
  }
}

mutation addAuthorsToEditor {
  addAuthorsToEditor(
    id: 33,
    authors_id: [7, 8, 9]
  ) {
    id
    name
    photo
    creationDate,
    authors {
      firstName
      lastName,
      books {
        id
      }
    }
  }
}

query GetAuthorsWithC {
  authorsWithC: allAuthors(lastName: "B") {
    ...AuthorFragment
  }
}

query GetAuthors {
  authorsWithC: allAuthors(lastName: "C") {
    ...AuthorFragment
  }
  
   allAuthors: allAuthors {
    ...AuthorFragment
  }
}

fragment AuthorFragment on Author {
  id
  firstName,
  lastName,
  books {
      id
      title
      summary
    }
}
```