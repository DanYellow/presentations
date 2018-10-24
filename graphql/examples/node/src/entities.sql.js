const Sequelize = require('sequelize')
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
})

sequelize
  .authenticate()
  .then(() => {
    console.log('Connection has been established successfully.')
  })
  .catch(err => {
    console.error('Unable to connect to the database:', err)
  })

const Book = sequelize.define('book', {
  releasedate: {
    type: Sequelize.STRING,
  },
  author: {
    type: Sequelize.STRING,
  },
  title: {
    type: Sequelize.STRING,
  },
  editor: {
    type: Sequelize.STRING,
  },
  coverImage: {
    type: Sequelize.STRING,
  },
  summary: {
    type: Sequelize.STRING,
  },
})

const Editor = sequelize.define('editor', {
  name: {
    type: Sequelize.STRING,
  },
  creationDate: {
    type: Sequelize.STRING,
  },
  photo: {
    type: Sequelize.STRING,
  },
})

const Author = sequelize.define('author', {
  firstName: {
    type: Sequelize.STRING,
  },
  lastName: {
    type: Sequelize.STRING,
  },
  photo: {
    type: Sequelize.STRING,
  },
})

// Relationships
// Author.belongsToMany(Editor, { as: 'editors', through: 'editor_author' })
// Author.hasMany(Book, { as: 'book' })

// Editor.belongsToMany(Author, { as: 'authors', through: 'editor_author' })
// Editor.hasMany(Book, { as: 'book' })

// Book.sync({ force: true })
// Author.sync({ force: true })
// Editor.sync({ force: true })

module.exports.book = Book
module.exports.author = Author
module.exports.editor = Editor
