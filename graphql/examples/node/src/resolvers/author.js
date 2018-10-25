const Entities = require('../entities.sql');
const { book: Book, author: Author, editor: Editor } = Entities;

const Utils = require('../utils');

module.exports = {
  Query: {
    author: async (_, { id }) => {
      const [err, book] = await Utils.to(
        Author.findOne(
          { where: { id }, include: [Book, Editor] },
          { raw: true }
        )
      );
      if (err) return false;

      return book;
    },
    authors: async () => {
      const [err, books] = await Utils.to(
        Author.findAll(
          {
            include: [Book, Editor],
          },
          { raw: true }
        )
      );
      if (err) return false;
      return books;
    },
  },
  Mutation: {
    createAuthor: async (_, { books, author, editors }) => {
      const [err, newAuthor] = await Utils.to(
        Author.create(
          {
            ...author,
            books,
            editors,
          },
          {
            include: [Book, Editor],
          }
        )
      );

      const [errEditor, newEditor] = await Utils.to(
        Editor.create(
          {
            ...editors[0],
            books,
          },
          {
            include: [Book],
          }
        )
      );

      newAuthor.addEditor(newEditor);

      if (err || errEditor) return false;

      return newAuthor;
    },
  },
};
