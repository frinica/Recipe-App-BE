# Recipe App

In this app you can get cooking inspiration by browsing ranom recipes, search for recipes you want to cook and save recipes to custom lists on your own profile for easy access in the future.
The goal of this project is to allow users to register, log in and log out. A user who is logged in will be able to create and handle their own lists.
This is a laravel project developed using VS Code and Docker. The user functionalities are developed using Sanctum.

## Installation

To run this app locally you need to have Docker installed on your computer and the doker extension in VS Code.
Start up the project in Docker by running **docker compose up** in the terminal.
Navigate to the docker extension and find the docker container.
Attach shell to the container.
In the shell write **cd recipe-app** and run migrations **php artisan migrate**.

## Usage

The project have two features:

1. Login/Register/Logout users.
   User related requests are all handled by the AuthController. In the controller you find these methods: - register: Registers a new user. - logout: Log out a user by removing their access token. - login: Creates an access token for the user so that they can acess protected routes. - userData: Fetches all available data about the logged in user.

2. Handle users custom lists.
   List related requests are handled in the CustomListController. All list-routes are protected and can only be accessed by an authorized user. Methods in the controller: - store: Creates a new list. - getAll: Fetches all of the users lists. - getByID: Fetches one of the users lists and all entries saved in the list. Entries are saved in a separate table (ListEntry). - update: Updates the ListEntry table when new entries are added to a list. The method allows a user to change names on lists too but the feature to change the name of a list has not yet been implemente in the frontend. - deleteRecipe: Removes an entry belonging to a specific list from the ListEntry table. - destroy: Removes a users list and removes the belonging entries.

## Related

Here is the related frontend project

https://github.com/frinica/Recipe-App-FE
