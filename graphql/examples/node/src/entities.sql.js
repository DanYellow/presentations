const faker = require('faker');
const times = require('lodash').times;

const Sequelize = require('sequelize');
const sequelize = new Sequelize('library', null, null, {
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
  storage: `./library.sqlite`,
});

sequelize
  .authenticate()
  .then(() => {
    console.log('Connection has been established successfully.');
  })
  .catch(err => {
    console.error('Unable to connect to the database:', err);
  });

const AuthorEditor = sequelize.define('author_editor', {});

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

// Relationships
Author.hasMany(Book);
Editor.hasMany(Book);

Book.belongsTo(Author);
Book.belongsTo(Editor);

Author.belongsToMany(Editor, {
  through: AuthorEditor,
});
Editor.belongsToMany(Author, {
  through: AuthorEditor,
});

/**
 * Update dataschema
 * Will delete all tables' content
 */
// Book.sync({ force: true });
// Author.sync({ force: true });
// Editor.sync({ force: true });

sequelize.sync({ force: true }).then(() => {
  times(10, _ => {
    console.log('name3', faker.name.lastName());
    Book.create(
      {
        title: faker.lorem.sentence(),
        releaseDate: faker.date.past(),
        summary: faker.lorem.text(),
        coverImage: faker.image.image(),
        author: {
          lastName: faker.name.lastName(),
          firstName: faker.name.firstName(),
          coverImage: faker.image.image(),
        },
        editor: {
          name: faker.lorem.sentence(),
        },
      },
      {
        include: [Author, Editor],
      }
    );
  });
});

module.exports.book = Book;
module.exports.author = Author;
module.exports.editor = Editor;
