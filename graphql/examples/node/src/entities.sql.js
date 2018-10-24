const Sequelize = require('sequelize');
const sequelize = new Sequelize('database', null, null, {
  host: 'localhost',
  dialect: 'sqlite',
  operatorsAliases: false,

  pool: {
    max: 5,
    min: 0,
    acquire: 30000,
    idle: 10000,
  },

  // SQLite only
  storage: './library.sqlite',
});

sequelize
  .authenticate()
  .then(() => {
    console.log('Connection has been established successfully.');
  })
  .catch(err => {
    console.error('Unable to connect to the database:', err);
  });

const Book = sequelize.define('book', {
  title: Sequelize.STRING,
  coverImage: Sequelize.STRING,
  summary: Sequelize.STRING,
  releaseDate: Sequelize.DATE,
});

const Editor = sequelize.define('editor', {
  name: Sequelize.STRING,
  creationDate: Sequelize.STRING,
  photo: Sequelize.STRING,
});

const Author = sequelize.define('author', {
  firstName: Sequelize.STRING,
  lastName: Sequelize.STRING,
  photo: Sequelize.STRING,
});

const AuthorEditor = sequelize.define('author_editor', {
  link: Sequelize.STRING,
});

// Relationships
Author.hasMany(Book);
Editor.hasMany(Book);

Book.belongsTo(Author);
Book.belongsTo(Editor);

Author.belongsToMany(AuthorEditor, { through: AuthorEditor });
Editor.belongsToMany(AuthorEditor, { through: AuthorEditor });

/**
 * Update dataschema
 * Will delete all tables' content
 */
// Book.sync({ force: true });
// Author.sync({ force: true });
// Editor.sync({ force: true });

module.exports.book = Book;
module.exports.author = Author;
module.exports.editor = Editor;
