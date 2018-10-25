const merge = require('lodash').merge;

const bookResolvers = require('./resolvers/book');
const authorResolvers = require('./resolvers/author');
const editorResolvers = require('./resolvers/editor');

module.exports.resolvers = merge(
  editorResolvers,
  authorResolvers,
  bookResolvers
);
