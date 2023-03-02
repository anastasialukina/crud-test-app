# crud-test-app
1. Clone the project repository
2. Run migrations via `php artisan migrate --seed` with the user seeder
3. Run command `php artisan api:login test@example.com password` in your console, you will get a token that looks like that: 
`eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNjc3NzU0ODg3LCJleHAiOjE2NzgwNTQ4ODcsIm5iZiI6MTY3Nzc1NDg4NywianRpIjoiamE2bTVzTXpvaFlDVXVudSIsInN1YiI6IjMzIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.RYmRPXzLFtYOcTAolw4t1BRNQ8gtKMH53mEzza7efFY`
4. If you do not have extensions for passing JWT tokens from the browser - install ModHeader extension and pass in with Bearer <token>.
5. Use this token for routes `api/data/create` with this token. Paste it again in the field 'Token'. Choose a method GET or POST. 
Here is example for JSON entry I used: 
`{
"employees":[
  {"firstName":"Joe", "lastName":"Dirk"},
  {"firstName":"Ann", "lastName":"Smith"},
  {"firstName":"Mark", "lastName":"Jones"}
]
}`
6. Warning: a token will expire in a 5 minutes, so you should get another one in console again (look at 2.). 
Alternatively, you can change default 5 minutes to more in 'config/jwt.php' from `'ttl' => env('JWT_TTL', 5),` to `'ttl' => env('JWT_TTL', 5000),` for example.
7. Now you can edit the entry with `api/data/edit/{your_id}` via code for example 
`$data->employees[0]->firstName = 'Mark';
$data->employees[1]->lastName = 'Erik';` in the field called 'Code'. 
  Notice: you can edit it in case you have created it.
8. Warning: I don't like this because it obliges me to use eval function which is not recommended by PHP creators because it is unsafe and actually VERY DANGEROUS. I think this is very bad practice.
9. Use route `api/data/index/` for accessing all data you created.
10. You can delete entries via 'delete' button.
11. You can run Codeception tests `php vendor/bin/codecept run` after you change consts `ENTRY_TO_DELETE_ID` and `ENTRY_TO_UPDATE_ID` with your data. 
Please remember that tests could be passed only if your DB is not empty. 
