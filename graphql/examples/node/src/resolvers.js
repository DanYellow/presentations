const Entities = require('./entities')
const db = require('./entities')
const { book: Book, editor: Editor, author: Author } = Entities

module.exports.resolvers = {
  Query: {
    getBook: ({ id }) => {
      return db.book.find(book.id === id)
    },
  },
  Mutation: {
    createBook: (root, { input }) => {
      const newBook = new Book({
        title: input.title,
        releaseDate: input.releaseDate,
        coverImage: input.coverImage,
        summary: input.summary,
        author: input.author,
      })

      newBook.id = newBook._id
      console.log('root', root, newBook.id)

      return new Promise(resolve => {
        newFriend.save(err => {
          if (err) reject(err)
          else resolve(newBook)
        })
      })
    },
  },
}
