const express = require('express')
const graphqlHTTP = require('express-graphql')

const schema = require('./src/schema')

const PORT = 4000

const root = {
  generateBook: () => ({
    id: require('crypto')
      .randomBytes(10)
      .toString('hex'),
    title: 'The catcher in the rye',
    summary: 'Can make you a killer... :/',
    releaseDate: new Date().toISOString(),
    coverImage: 'https://via.placeholder.com/300.png/09f/fff',
    author: {
      firstName: 'Jerome David',
      lastName: 'Salinger',
      image: 'https://via.placeholder.com/300.png/09f/fff',
    },
    editor: {
      name: 'Night books',
      logo: 'https://via.placeholder.com/300.png/09f/fff',
      creationDate: new Date().toISOString(),
    },
  }),
}

const app = express()
app.use(
  '/graphql',
  graphqlHTTP({
    rootValue: root,
    schema,
    graphiql: true,
  })
)

app.listen(PORT, () => console.log('Now browse to localhost:%s/graphql', PORT))
