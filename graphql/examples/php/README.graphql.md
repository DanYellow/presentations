```


# mutation CreateAnAuthor ($author: AuthorInput!) {
#   createAuthor: createAuthor(author: $author) {
#     ...AuthorFragment
#   }
# }

# mutation DeleteAnAuthor {
#   deleteAuthor: deleteAuthor(id: 4) {
#     ...AuthorFragment
#   }
# }


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