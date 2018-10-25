const Entities = require('../entities.sql');
const { book: Book, author: Author, editor: Editor } = Entities;

const Utils = require('../utils');

module.exports = {
  Query: {
    book: async (_, { id }) => {
      const [err, book] = await Utils.to(
        Book.findOne(
          { where: { id }, include: [Author, Editor] },
          { raw: true }
        )
      );
      if (err) return false;

      return book;
    },
    books: async () => {
      const [err, books] = await Utils.to(
        Book.findAll({ include: [Author, Editor] }, { raw: true })
      );

      if (err) return false;
      return books;
    },
  },
  Mutation: {
    createBook: async (_, { book, author, editor }) => {
      const [err, newBook] = await Utils.to(
        Book.create(
          {
            ...book,
            releaseDate: new Date().toISOString(),
            author,
            editor,
          },
          {
            include: [Author, Editor],
          }
        )
      );

      if (err) return false;
      return newBook;
    },
  },
};
