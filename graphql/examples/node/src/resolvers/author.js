const Sequelize = require('sequelize');
const Op = Sequelize.Op;

const Entities = require('../entities.sql');
const { book: Book, author: Author, editor: Editor } = Entities;

const Utils = require('../utils');

module.exports = {
  Query: {
    author: async (_, { id }) => {
      const [err, author] = await Utils.to(
        Author.findOne(
          { where: { id }, include: [Book, Editor] },
          { raw: true }
        )
      );
      if (err) return false;

      return author;
    },
    authors: async (_, { page = 1 }) => {
      const nbItemsPerPage = 5;
      page = page - 1;
      const [err, authors] = await Utils.to(
        Author.findAll(
          {
            include: [Book, Editor],
            offset: page * nbItemsPerPage,
            limit: nbItemsPerPage,
          },
          { raw: true }
        )
      );
      if (err) return false;
      return authors;
    },
  },

  Mutation: {
    createAuthor: async (_, { books = [], author }) => {
      const [err, newAuthor] = await Utils.to(
        Author.create(
          {
            ...author,
            books,
          },
          {
            include: [Book],
          }
        )
      );

      books.forEach(async book => {
        const [_, newEditor] = await Utils.to(
          Editor.create(
            {
              ...book.editor,
              books: [book],
            },
            {
              include: [Book],
            }
          )
        );

        await newAuthor.addEditor(newEditor);
      });

      if (err) return false;

      return newAuthor;
    },

    deleteAuthor: async (_, { id }) => {
      const [err, author] = await Utils.to(
        Author.destroy(
          {
            where: {
              id,
            },
          },
          { raw: true }
        )
      );

      if (err) return false;
      return author;
    },

    addEditorToAuthor: async (_, { editor, author }) => {
      const [err, foundAuthor] = await Utils.to(
        Author.findOne(
          {
            ...(author
              ? {
                  where: {
                    [Op.or]: [
                      { lastName: author.lastName },
                      { firstName: author.firstName },
                      { id: author.id },
                    ],
                  },
                }
              : {}),
            include: [Book, Editor],
          },
          { raw: true }
        )
      );

      if (err) return false;
      if (author && foundAuthor) {
        const [newEditorError, newEditor] = await Utils.to(
          Editor.create({
            ...editor,
          })
        );
        await foundAuthor.addEditor(newEditor);

        if (newEditorError) return false;
      }
      return foundAuthor;
    },
  },
};
