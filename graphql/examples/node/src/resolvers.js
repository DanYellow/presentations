const Entities = require('./entities')
const { books: booksDB, authors: authorsDB, editors: editorsDB } = Entities

module.exports.resolvers = {
  Query: {
    book: id => {
      return booksDB.find(book.id === id)
    },

    books: () => {
      return booksDB
    },
  },
  Mutation: {
    createBook: (root, { book, author }) => {
      const newBook = {
        id: require('crypto')
          .randomBytes(10)
          .toString('hex'),
        title: book.title,
        releaseDate: book.releaseDate,
        coverImage: book.coverImage,
        summary: book.summary,
        author,
      }

      return new Promise(resolve => {
        booksDB.push(newBook)
        resolve(newBook)
      })
    },
  },
}
