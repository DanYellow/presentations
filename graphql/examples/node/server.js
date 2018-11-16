const express = require('express');
const graphqlHTTP = require('express-graphql');

const schema = require('./src/schema');

const PORT = 4000;

const app = express();
app.use(
  '/__graphql',
  graphqlHTTP({
    schema,
    graphiql: true,
  })
);

app.listen(PORT, () =>
  console.log('Now browse to localhost:%s/__graphql', PORT)
);
