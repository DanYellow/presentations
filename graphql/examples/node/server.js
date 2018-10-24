const express = require('express')
const graphqlHTTP = require('express-graphql')

const schema = require('./src/schema')

const PORT = 4000

const root = { hello: () => ({ name: 'Hello world!' }) }

// const root = { hello: () => ({
//     character: {
//         name: "fzefze"
//     }
// }) };

const app = express()
app.use(
  '/graphql',
  graphqlHTTP({
    schema,
    //   rootValue: root,
    graphiql: true,
  })
)

app.listen(PORT, () => console.log('Now browse to localhost:%s/graphql', PORT))
