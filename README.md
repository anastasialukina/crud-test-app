# crud-test-app
1. Clone the project repository.
2. Run migrations via `php artisan migrate --seed` with the user seeder
3. Run the command `php artisan api:login test@example.com password` in your console. You will receive a token that looks like this: 
`eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNjc3NzU0ODg3LCJleHAiOjE2NzgwNTQ4ODcsIm5iZiI6MTY3Nzc1NDg4NywianRpIjoiamE2bTVzTXpvaFlDVXVudSIsInN1YiI6IjMzIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.RYmRPXzLFtYOcTAolw4t1BRNQ8gtKMH53mEzza7efFY`
4. If you don't have extensions for passing JWT tokens from the browser, install the ModHeader extension and pass it in with Bearer. <token>.
5. Use this token for the api/data/create route. Paste it again in the field 'Token'. Choose the method GET or POST. 
    Here is an example of the JSON entry I used:
`{
"employees":[
  {"firstName":"Joe", "lastName":"Dirk"},
  {"firstName":"Ann", "lastName":"Smith"},
  {"firstName":"Mark", "lastName":"Jones"}
]
}`
6. Note that a token will expire in 5 minutes, so you will need to get another one in the console again (see step 2). Alternatively, you can change the default 5 minutes to more in config/jwt.php from `'ttl' => env('JWT_TTL', 5),` to `'ttl' => env('JWT_TTL', 5000),` for example.
7. Now you can edit the entry with `api/data/edit/{your_id}` via code. For example: 
`$data->employees[0]->firstName = 'Mark';
$data->employees[1]->lastName = 'Erik';` in the field called 'Code'. 
  Note that you can only edit an entry if you have created it.
8. Warning: I don't recommend using the eval function in your code because it is unsafe and can be very dangerous. I think this is very bad practice.
9. Use the `api/data/index/` route to access all the data you created.
10. You can delete entries via 'delete' button.
11. You can run Codeception tests via php vendor/bin/codecept run after you change the constants ENTRY_TO_DELETE_ID and ENTRY_TO_UPDATE_ID with your data. Please note that tests can only be passed if your database is not empty.
