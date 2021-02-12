# ORDER PLACEMENT
**What does this REPO do?**
This is a single endpoint Api built on php framework(laravel)
used the collect and submit multiple orders.

**Task to be completed**
It is able to collect customer email,id's of products they want and each products quantity

**How  should it be tested**

1. Clone repo into your local severs,www directory(wampp) or htdocs(xampp),
2. copy or create an env file with cmd enter
                *cp .env.example .env
                *php artisan key:generate
3. specify data base in .env filr
4. run *php artisan migrate:refresh --seed
                     
5. making use of post man you can make calls our endpoint using

         **Make order**= (POST) http://127.0.0.1:8000/api/AddCart 

**Read exammples and corresponding input syntax below**

                syntax for body parameter
                <pre>
               {
                    "customer_email":"emeka@gmail.com",
                    "product_id":"3,4,7",
                    "product_quantity":"1,2,5"
                }
                 </pre>
                      
                  
                   
