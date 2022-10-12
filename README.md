# Camagru


## Description

The aim of Camagru project was to write a fully functional image sharing social media platform without any use of third party frameworks. The backend had to be done completely with PHP with the usage of MySQL database. For styling I ended up writing my own bootstrap -like CSS framework to help me with quick styling of components and easy adjusting later. For UI I took some inspiration from the works of [Joanna Mehtälä](https://fi.linkedin.com/in/joannamehtala)

I tried to make the project as secure as I know and XSS and SQL-injction attacks should be if not impossible, at least pretty hard to pull off. 

During development I learned a whole lot about project architeture, security, SQL, PHP and it is the first BIG project I've built completely from ground up. 


## Usage

In Camagru you can create a user and start uploading pictures either through webcam or upload files from your device and add stickers to the images. After you have uploaded your picture for everyone to see, other people can like it or comment on it and you will get notified by comments and likes by email. You can see the pictures of other people even if you don't have a user but you will be unable to like or comment posts.

Your profile will be authenticated by emailing you a link containing unique activation token.

## How to Install and Run the Project

Easiest way to run the application is running it with MAMP/XAMP. 

Then in your `apache2/htdocs` directory run `git clone git@github.com:JuhoKangas/42_camagru.git camagru`. The project has to be cloned to directory called `camagru` for it to work correctly. 

After cloning the project go to [localhost:8080/camagru/index.php](http://localhost:8080/camagru/index.php) to create the database. 

You might need to change the $DB_PASS in `camagru/config/database.php` and `/camagru/src/functions.php` to the password you have set for your backend.
 
## Previews

### Login screen
<img width="750" alt="Screen Shot 2022-10-12 at 2 50 47 PM" src="https://user-images.githubusercontent.com/46278255/195339013-86eda722-c737-40d3-b625-9cf1a4390cb7.png">

### Upload file view
<img width="750" alt="image" src="https://user-images.githubusercontent.com/46278255/195339196-70086207-3526-4b31-8cba-6e49c442e2bf.png">

### Mobile view of the feed
<img width="200" alt="image" src="https://user-images.githubusercontent.com/46278255/195339303-89bf4b19-a896-4637-be43-87617f46a0da.png">

### Desktop view of the feed
<img width="750" alt="image" src="https://user-images.githubusercontent.com/46278255/195339409-dd5b93ce-7f68-4e73-be77-4b903aed8f6f.png">

### View of the feed when user is not logged in
<img width="750" alt="image" src="https://user-images.githubusercontent.com/46278255/195339518-a2f456bd-86d5-4e38-af4a-71311c541949.png">


