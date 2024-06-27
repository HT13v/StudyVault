const express = require('express');
        const bodyParser = require('body-parser');
        const sql = require('mssql');

        const app = express();
        const port = 5500;

        app.use(bodyParser.urlencoded({ extended: true }));
        app.use(bodyParser.json());

        const dbConfig = {
            user: 'DESKTOP-DVP51CJ\\USER',         
            server: 'DESKTOP-DVP51CJ\\SQLEXPRESS',
            database: 'users',     
            options: {
                encrypt: false,            
                enableArithAbort: true
            }
        };

        app.post('/signup', async (req, res) => {
            const { id, fname, lname, email, psw } = req.body;

            try {
                await sql.connect(dbConfig);
                const result = await sql.query`INSERT INTO users (id, fname, lname, email, psw) VALUES (${id}, ${fname}, ${lname}, ${email}, ${psw})`;

                res.status(200).send('User data inserted successfully!');
            } catch (err) {
                console.error(err);
                res.status(500).send('Error inserting user data');
            } finally {
                sql.close();
            }
        });

        app.use(express.static('public'));

        app.listen(port, () => {
            console.log(`Server running at http://localhost:${port}/`);
        });