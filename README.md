# workscheduler
A Simple School Project.
# Changes
1. Created 2 middlewares named as `isAdmin` and `PreventBackHistory` and registered those into `Kernel`.
  * `isAdmin` middleware will be used by us to check whether logged in user is an `Admin` or not.
  * `PreventBackHistory` middleware prevents user to go  back to profile page after logout.
  * `HomeController` also uses `PreventBackHistory` middleware.
2. Modified `create_users_table` and added a field `isAdmin`.
  * `isAdmin` is boolean and will tell us if user is `Admin`.
3. Created `AdminController` for `Admins`.
