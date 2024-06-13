<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

To get started with Job Board API, follow these steps:

1. **Clone the repository:**
    ```
    git clone git@github.com:shikharbahikmagar/laravel_job_board_api.git
    ```

2. **Install Composer Dependencies:**
    ```
    composer install
    ```

3. **Install NPM Dependencies:**
    ```
    npm install
    ```

4. **Create a copy of the `.env.example` file and rename it to `.env`.**

       -change the database name (DB_DATABASE) to laravel_job_board_api or your own database name 

6. **Generate an application key:**
    ```
    php artisan key:generate
    ```

7. **Run Migrations:**
    ```
    php artisan migrate (make sure database is created before migrating)
    ```

8. **Start the development server:**
    ```
    php artisan serve

    use php artisan db:seed to insert the dummy data using seeder

    In DatabaseSeeder.php file uncomment one by one line and run php artisan db:seed command
        $this->call(EmployersTableSeeder::class);
        // $this->call(JobPostsTableSeeder::class);
        //$this->call(JobSubmissionsTableSeeder::class);

To test the API Use Postman API Platform

1. Setup Postman

       Download and install the Postman (or you can use web version)

2. User Register API

       api: http://127.0.0.1:8000/api/user/register (method = post)

       //data example 
       data: {
                "name": "shikhar thapa",
                "email": "sonamgrg141@gmail.com",
                "password": "123456789",
                "confirm_password": "123456789"
                }
3. Response Example

        {
            "success": true,
            "data": {
                "token": "32|QJ3kSFPcH9M5yvMecf6rvoMnMi0tuAinWWwddVBHa53b6f69",
                "name": "shikhar thapa"
            },
            "message": "user registered successfully"
        }
    

5. Login User API
   
        http://127.0.0.1:8000/api/user/login (method = post)

        to login above token should be inserted in headers as
           Key = "Authorization"
           value = "Bearer 32|QJ3kSFPcH9M5yvMecf6rvoMnMi0tuAinWWwddVBHa53b6f69"

7. Login Response Example

           {
                "success": true,
                "data": {
                    "token": "32|QJ3kSFPcH9M5yvMecf6rvoMnMi0tuAinWWwddVBHa53b6f69",
                    "name": "shikhar thapa"
                },
                "message": "user logged in successfully"
            }

           this token will be used to do other operations like applying for the job (use like above example while login)

8. User Profile

            login token should be used as above example while login
   
           http://127.0.0.1:8000/api/user/profile


9. Get all available jobs

           http://127.0.0.1:8000/api/jobs

10. search for the job

           //end point
    
           http://127.0.0.1:8000/api/search-jobs

           //data
           {
                "search": "react"
            }

10. Apply for the job

        end point (make sure token is used)
    
        http://127.0.0.1:8000/api/user/add-job-submission/3

        data
        {
            "resume": "my_resume.pdf",
            "cover_letter": "test"
        }

        other user details will be fetched from users table
        instant email to employer will be send

12. Register as a Employer

        end point
        http://127.0.0.1:8000/api/employer/register

        data
            {
            "name": "shikhar",
            "email": "user22@gmail.com",
            "phone_number": "9864894584",
            "address": "pokhara",
            "company_name": "abcd",
            "company_address": "bijaypur",
            "password": "123456789"
        }

        you will get a token use it to login (same as user login)

13. Login as a Employer

        end point (method = post)
        http://127.0.0.1:8000/api/employer/login

        data example (use token)
            {
            "email": "shikharbahik5@gmail.com",
            "password": "123456789"
        }

        after logged in you will get another token use it to do operations like posting job editing job details updateing job submission status

14. post jobs

        end point (method = post)
        http://127.0.0.1:8000/api/employer/add-job

        data example
        {
            "job_title": "java developer", 
            "company_name": "abc", "location": "newroad, pokhara", 
            "skills": "java",
            "experience": "2 years", 
            "salary": "20000", 
            "description": "only for senior developers", 
            "status": 1
        }

        //employer id will be fetched from the auth()->user()->id 

16. Delete Job
    
            end point (6 = job_post_id) (method = delete)
            http://127.0.0.1:8000/api/employer/delete-job/6

            use token of employer and only job post owner (employer) can delete or update the post
17. update job posts

            end point (4 is job post id) method = put
            http://127.0.0.1:8000/api/employer/update-job-submission/4

            data
            {
                "job_title": "java developer", 
                "company_name": "abc", "location": "newroad, pokhara", 
                "skills": "java",
                "experience": "2 years", 
                "salary": "20000", 
                "description": "only for senior developers", 
                "status": 1
            }

18.  Update Job Application status

            endpoint (method = put)
             http://127.0.0.1:8000/api/employer/update-job-submissions-status/1
            status can be only pending, accepted and rejected
             data
             {
                "status": "accepted"
            }

             after 10 minutes of submission the email will be sent to user.

             Resend is used to send email use the below api key in .env file
     
             RESEND_API_KEY = re_Rak2yziQ_Asi1evHCyfDm5AG3sWJJ1LNW

             make sure this address is used in MAIL_FROM_ADDRESS in .env
             MAIL_FROM_ADDRESS="no-reply@shikharbahik.com.np"

20. Get the job submissions details

            this details only available to job post owner (employer)

            endpoint
            http://127.0.0.1:8000/api/employer/get-job-submissions

            employer should be logged in

18 Logout

        for user
        end point (method = get)
        http://127.0.0.1:8000/api/user/logout

        for employer method = get
        http://127.0.0.1:8000/api/employer/logout

        make sure token is inserted as already explained above
