const express = require('express');
const mongoose = require('mongoose');
const bodyParser = require('body-parser');
const path = require('path');

const app = express();
const PORT = process.env.PORT || 3000;


app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());


mongoose.connect('mongodb://localhost:27017/faqDB', {
    useNewUrlParser: true,
    useUnifiedTopology: true
});
const querySchema = new mongoose.Schema({
    query: String,
    timestamp: { type: Date, default: Date.now }
});
const Query = mongoose.model('Query', querySchema);


app.use(express.static(path.join(__dirname, 'public')));


app.post('/submitQuery', (req, res) => {
    const newQuery = new Query({
        query: req.body.query
    });
    newQuery.save(err => {
        if (err) {
            res.status(500).send('Error saving query');
        } else {
            res.status(200).send('Query submitted successfully');
        }
    });
});

app.get('/getQueries', (req, res) => {
    Query.find({}, (err, queries) => {
        if (err) {
            res.status(500).send('Error retrieving queries');
        } else {
            res.status(200).json(queries);
        }
    });
});


app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
