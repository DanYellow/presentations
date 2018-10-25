const Entities = require('../entities.sql');
const { book: Book, author: Author, editor: Editor } = Entities;

const Utils = require('../utils');

module.exports = {
  Query: {
    editor: async (_, { id }) => {
      const [err, editor] = await Utils.to(
        Editor.findOne(
          { where: { id }, include: [Book, Author] },
          { raw: true }
        )
      );
      if (err) return false;

      return editor;
    },
    editors: async () => {
      const [err, editors] = await Utils.to(
        Editor.findAll(
          {
            include: [Book, Author],
          },
          { raw: true }
        )
      );
      if (err) return false;
      return editors;
    },
  },
  Mutation: {
    createEditor: async (_, { editor, authors }) => {
      const [err, newEditor] = await Utils.to(
        Editor.create(
          {
            ...editor,
            authors,
          },
          {
            include: [Author],
          }
        )
      );

      const [errAuthor, newAuthor] = await Utils.to(
        Author.create({
          ...authors[0],
        })
      );

      newEditor.addAuthor(newAuthor);

      if (err || errAuthor) return false;

      return newEditor;
    },
  },
};
