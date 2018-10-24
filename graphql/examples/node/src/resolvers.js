const Entities = require('./entities.sql');
const { book: Book, author: authorsDB, editors: editorsDB } = Entities;

const Utils = require('./utils');

module.exports.resolvers = {
  Query: {
    book: async (root, { id }) => {
      const [err, book] = await Utils.to(
        Book.findOne({ where: { id } }, { raw: true })
      );
      if (err) return false;

      return book;
    },

    books: async () => {
      const [err, books] = await Utils.to(Book.findAll({ raw: true }));
      if (err) return false;
      return books;
    },
  },
  Mutation: {
    createBook: async (root, { book, author }) => {
      const [err, newBook] = await Utils.to(
        Book.create({
          ...book,
        })
      );
      if (err) return false;
      return newBook;
    },
  },
};
