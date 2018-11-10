query {
  allAuthors: allAuthors(lastName: "Pattie") {
    firstName
    photo
    books {
      id
      title
      summary
    }
  }
}