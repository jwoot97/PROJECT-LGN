
|- PROJECT DESCRIPTION        -|

"PROJECT-LGN" is an example of a basic login page, frontend and backend.  The "frontend" is built in HTML, CSS, and JavaScript.  The "backend" is built in PHP with data storage in MySQL, hosted on a XAMPP client through Apache and MySQL.

|- REQUIREMENTS [ EXTERNAL ]  -|

1. Build a web page using HTML, CSS, JavaScript or React.  (If you use PHP that would be great) that allows users to enter login credentials.  After a successful login, show the logout option and display successful login message.
2. Build the necessary REST endpoints that allow users to sign up with an email address and password, log in with an existing email address and password, and logout.  Design a database schema for your preferred database engine to store and query the credentials.  Make sure to include the SQL table creation scripts in your repository.
3. Provide a Postman collection or sufficient documentation for testing the routes and validating the functionality.

|- PREREQUISITES              -|

Since the project depends on the XAMPP client hosting a PHP and SQL server, it's required for the project to run properly.
XAMPP DOWNLOAD: https://www.apachefriends.org

Once XAMPP has been downloaded, open the source directory [ example: C:/xampp/ ] and navigate to the /htdocs/ directory.  Place the unzipped PROJECT-LGN directory inside /htdocs.

The proper file structure should look similar to this: [ C:/xampp/htdocs/PROJECT-LGN ].

Next, initialize the database and table, then populate it with test data.  Open the XAMPP Control Panel, start Apache and MySQL, then wait for their initialization to complete.  After both services are running, click on the "Shell" button on the sidebar.  In the prompt, type "mysql --user=root" and hit enter.

Copy all of the lines from the "/SQL/DB-CREATION.sql" script, and paste them in the terminal.  Once those lines run, the database [ lgn_db ] and table [ lgn_db.users ] has been created.  Now, populate it with test data, either using the existing "/SQL/USER-POPULATION.sql" script, or manually with INSERT statements.  Last, run a test query to make sure all data has been properly inserted: [ SELECT * FROM users; ].

|- RUNNING THE PROJECT        -|

Once the data has been confirmed in the table, and both of the required services are running [ Apache, MySQL ], enter the following path into the URL bar of a browser: "http://localhost/PROJECT-LGN/page.html".  A login screen should appear.  If it doesn't, return to the PREREQUISITES section of this document and review the steps.

|- ENDPOINTS                  -|

[ login          ]
Collects the input data from the textboxes, compares the user's entered password to the one stored in the lgn_db.users table that is related to the user's entered email.

[ signup         ]
Collects the input data from the textboxes, determines if email is present in database, and adds the email and password if not. Contains logic to ensure email is in the proper format [ user@domain.com ], and that a password was entered.

[ collectAllData ]
Collects all data from lgn_db.users and displays it on the page, as a reference for testers to ensure they have valid info to test the page with.  Note that all passwords are displayed as-is in the database - encoded in base64.

(!) Only for testing purposes; the endpoint would not be accessible on a live site.

|- USER PATHS                 -|

|  PATH01: NO DATA ENTERED, LOGIN BUTTON PRESSED
|  RESULT: "INVALID EMAIL OR PASSWORD" ERROR MESSAGE SHOWN.

|  PATH02: ONLY EMAIL ENTERED, LOGIN BUTTON PRESSED
|  RESULT: "INVALID EMAIL OR PASSWORD" ERROR MESSAGE SHOWN.

|  PATH03: ONLY PASSWORD ENTERED, LOGIN BUTTON PRESSED
|  RESULT: "INVALID EMAIL OR PASSWORD" ERROR MESSAGE SHOWN.

|  PATH04: INVALID EMAIL/PASSWORD ENTERED, LOGIN BUTTON PRESSED
|  RESULT: "INVALID EMAIL OR PASSWORD" ERROR MESSAGE SHOWN.

|  PATH05: VALID EMAIL/PASSWORD ENTERED, LOGIN BUTTON PRESSED
|  RESULT: TEXTBOXES DISAPPEAR, "LOGIN SUCCESSFUL" MESSAGE SHOWN.  LOGIN BUTTON CHANGES TO LOGOUT BUTTON.

|  PATH06: COLLECTALLDATA BUTTON PRESSED
|  RESULT: DATABASE RESULTS DISPLAY BENEATH BUTTONS AND TEXTBOXES.

|  PATH07: AFTER SUCCESSFUL LOGIN, LOGOUT BUTTON PRESSED
|  RESULT: TEXTBOXES REAPPEAR, ALL MESSAGES DISAPPEAR.  LOGOUT BUTTON CHANGES BACK TO LOGIN BUTTON.

|  PATH08: VALID EMAIL/PASSWORD ENTERED, SIGN UP BUTTON PRESSED
|  RESULT: "SIGN UP COMPLETE." MESSAGE SHOWN. EMAIL/PASS COMBO ADDED TO DATABASE.

|  PATH09: INVALID EMAIL FORMAT ENTERED, SIGN UP BUTTON PRESSED
|  RESULT: "INVALID EMAIL FORMAT" ERROR MESSAGE SHOWN.

|  PATH10: VALID EMAIL ENTERED & NO PASSWORD, SIGN UP BUTTON PRESSED
|  RESULT: "INVALID REQUEST" ERROR MESSAGE SHOWN.

|  PATH11: EXISTING EMAIL ENTERED, SIGN UP BUTTON PRESSED
|  RESULT: "USER WITH EMAIL ALREADY EXISTS." INFO MESSAGE SHOWN.

|- TODO                   -|

N/A
