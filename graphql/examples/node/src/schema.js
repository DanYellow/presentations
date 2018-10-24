const { makeExecutableSchema } = require('graphql-tools')

const resolvers = require('./resolvers').resolvers

const typeDefs = `
    type Book {
        id: ID
        title: String
        releaseDate: String
        coverImage: String
        summary: String
        author: Author
    }

    input BookInput {
        id: ID
        title: String!
        editor: Editor!
        author: Author!
        photo: String
    }

    type Author {
        firstName: String
        lastName: String
        books: [Book]
        editor: Editor
        photo: String
    }

    input AuthorInput {
        firstName: String!
        lastName: String!
        books: [Book]!
        editor: Editor!
        photo: String
    }

    type Editor {
        name: String
        authors: [Author]
        books: [Book]
        creationDate: String
        photo: String
    }

    input EditorInput {
        name: String!
        authors: [Author]
        books: [Book]
        creationDate: String
        photo: String
    }

    type Mutation {
        createBook(input: BookInput): Book
        updateBook(input: BookInput): Book
        deleteBook(id: ID!): String

        createAuthor(input: AuthorInput): Author
        updateAuthor(input: AuthorInput): Author
        deleteAuthor(id: ID!): String
        
        createEditor(input: EditorInput): Editor
        updateEditor(input: EditorInput): Editor
        deleteEditor(id: ID!): String
    }

    type Query {
        getBook(id: ID): Book
    }
`

const schema = makeExecutableSchema({ typeDefs, resolvers })

module.exports.schema = schema
