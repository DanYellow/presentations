const { makeExecutableSchema } = require('graphql-tools');

const resolvers = require('./resolvers').resolvers;

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
        editor: Editor
    }

    input BookInput {
        id: ID
        title: String!
        coverImage: String
        summary: String
        releaseDate: String
        author: AuthorInput
        editor: EditorInput
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
        photo: String
        editor: EditorInput
        books: [BookInput]
    }

    type Editor {
        id: ID
        name: String
        authors: [Author]
        book: [Book]
        creationDate: String
        photo: String
    }

    input EditorInput {
        id: ID
        name: String!
        authors: [AuthorInput]
        book: [BookInput]
        creationDate: String
        photo: String
    }

    type Mutation {
        createBook(book: BookInput, author: AuthorInput, editor: EditorInput): Book
        updateBook(book: BookInput): Book
        deleteBook(id: ID!): String
        generateBook: Book

        createAuthor(books: [BookInput], author: AuthorInput, editor: EditorInput): Author
        updateAuthor(author: AuthorInput): Author
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
        """
        Returns all books
        """
        books: [Book]

        editors:[Editor]
        editor:Editor

        authors:[Author]
        author(id: ID): Author
    }
`;

const schema = makeExecutableSchema({ typeDefs, resolvers });

module.exports = schema;
