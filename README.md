<p align="center"><a href="https://laravel.com" target="_blank">
<div class="" style="background-image: url('https://g.top4top.io/p_2271zbiqx1.png'); height: 200px; background-repeat: no-repeat; background-size: contain; background-position: center;">
</div>

## About The Project 🤔 ℹ️

A restaurant application that helps managing the reservations and querying the available tables ing the restaurant.    

## Application Features ✨ 🤩
- Authentication
- Managing Users (Create, Delete, View All)
- Retrieving All Reservations For A Specific Day Or In General
- Managing Reservations (Create, Delete, View All)
- Managing Restaurant Tables (Create, Delete, View All)
- Controlling The Opening And Closing Times For the Restaurant

## Database Tables 🗃
- Users Table
    - Contains all information related to the users|employees of the restaurant.
- Roles Table
    - Contains all information related to the users|employees roles there are only to [Admin, Employee].
- Table Types
    - Contains all information related to the table types that are existed in the restaurant.
- Tables Table
  - Contains all brief information related to the tables that are existed in the restaurant.
- Customers Table
  - Contains all brief information related to the customers.
- Reservations Table
    - Contains all information related to the reservations.

## Database ERD & Relationships 🖇

<div style="height: 400px; width: 100%; background-size: 100%; background-image: url('https://github.com/soaod/restaurant/blob/master/Database%20Design/drawSQL-export-2022-03-21_23_47.png?raw=true');"></div>


## Set up And Start Using The Application 🚀
<mark>
    Make Sure You Have Composer And NPM Installed In Your System.
</mark>
<h4>
    After cloning the repo, You need to run these commands:
</h4>
<ol>
    <li>
        <code>npm install</code>
    </li>
    <li>
        <code>composer install</code>
    </li>
</ol>

<h4>
You also can use Docker to start using this application By running this command
</h4>
<mark>
    Make Sure You Have Docker Installed In Your System.
</mark>
<br>
<code>
    docker-compose up --force-recreate --build -d
</code>

## API Collection Are Available Using Insomnia
- You can import the collection to start testing the api
