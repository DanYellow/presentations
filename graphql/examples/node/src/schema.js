const { makeExecutableSchema } = require('graphql-tools')

const resolvers = require('./resolvers').resolvers

const typeDefs = `
    """
    A book
    """
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
        editor: EditorInput!
        author: AuthorInput!
        photo: String
        summary: String
    }

    type Author {
        id: ID
        firstName: String
        lastName: String
        books: [Book]
        editor: Editor
        photo: String
    }

    input AuthorInput {
        id: ID
        firstName: String!
        lastName: String!
        books: [BookInput]
        editor: EditorInput
        photo: String
    }

    type Editor {
        id: ID
        name: String
        authors: [Author]
        books: [Book]
        creationDate: String
        photo: String
    }

    input EditorInput {
        id: ID
        name: String!
        authors: [AuthorInput]
        books: [BookInput]
        creationDate: String
        photo: String
    }

    type Mutation {
        createBook(book: BookInput, author: AuthorInput): Book
        updateBook(book: BookInput): Book
        deleteBook(id: ID!): String
        generateBook: Book

        createAuthor(input: AuthorInput): Author
        updateAuthor(input: AuthorInput): Author
        deleteAuthor(id: ID!): String
        
        createEditor(input: EditorInput): Editor
        updateEditor(input: EditorInput): Editor
        deleteEditor(id: ID!): String
    }

    type Query {
        """
        Fetch a book by ID
        """
        book(id: ID): Book
        books: [Book]
    }

`

const schema = makeExecutableSchema({ typeDefs, resolvers })

module.exports = schema
