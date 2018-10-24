const mongoose = require('mongoose')

mongoose.connect('mongodb://localhost/library')

const bookSchema = new mongoose.Schema({
  release: {
    type: String,
  },
  author: {
    type: String,
  },
  name: {
    type: String,
  },
  type: {
    type: Number,
  },
  coverImage: {
    type: String,
  },
  summary: {
    type: String,
  },
})

module.exports.book = mongoose.model('book', bookSchema)

const authorSchema = new mongoose.Schema({
  release: {
    type: String,
  },
  author: {
    type: String,
  },
  name: {
    type: String,
  },
  type: {
    type: Number,
  },
  coverImage: {
    type: String,
  },
  summary: {
    type: String,
  },
})

module.exports.book = mongoose.model('author', authorSchema)

const editorSchema = new mongoose.Schema({
  name: {
    type: String,
  },
  authors: {
    type: Array,
  },
  books: {
    type: Array,
  },
  creationDate: {
    type: Number,
  },
  logo: {
    type: String,
  },
})

module.exports.editor = mongoose.model('editor', editorSchema)
