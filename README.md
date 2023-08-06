# **Stack:**
PHP ^8.1 Lumen (10.0.0) (Laravel Components ^10.0) + PostgreSQL 13.6 + tymon/jwt-auth


# **Task:**
Create RESTFull API.


**Description:**
Create the API to share the company's information for the logged users.
Please use the Repository-Service pattern in your task.


**Details:**
Create DB migrations for the tables: users, companies, etc.
Suggest the DB structure. Fill the DB with the test data.


**Endpoints:**
- https://domain.com/api/user/register
— method POST
— fields: first_name [string], last_name [string], email [string], password [string],
phone [string]


- https://domain.com/api/user/sign-in
— method POST
— fields: email [string], password [string]


- https://domain.com/api/user/recover-password
— method POST/PATCH
— fields: email [string] // allow to update the password via email token


- https://domain.com/api/user/companies
— method GET
— fields: title [string], phone [string], description [string]
— show the companies, associated with the user (by the relation)


- https://domain.com/api/user/companies
— method POST
— fields: title [string], phone [string], description [string]
— add the companies, associated with the user (by the relation)



# **Instruction:**
## **Without bearer token:**
1. Register:
POST with fields described top in to [https://lumen10.semen.in.ua/api/user/register](https://lumen10.semen.in.ua/api/user/register)


2. Sign in:
POST to [https://lumen10.semen.in.ua/api/user/sign-in](https://lumen10.semen.in.ua/api/user/sign-in)


3. Recover passw:
3.1 POST with 'email' field to [https://lumen10.semen.in.ua/api/user/recover-password](https://lumen10.semen.in.ua/api/user/recover-password)
3.2 PATCH with 'token' field to [https://lumen10.semen.in.ua/api/user/recover-password](https://lumen10.semen.in.ua/api/user/recover-password)



## **With bearer token only:**
4. Companies:
GET to [https://lumen10.semen.in.ua/api/user/companies](https://lumen10.semen.in.ua/api/user/companies)


5. Add and attach companies to user:
POST to [https://lumen10.semen.in.ua/api/user/companies](https://lumen10.semen.in.ua/api/user/companies)

