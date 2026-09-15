PCSCMS STARTER PACKAGE
=======================

This package contains:
- PHP + MySQL + PDO
- Bootstrap 5
- Login/logout
- Two roles only: Admin and Inventory Staff
- Admin-only account management
- Employee Management CRUD
- Glass/tinted responsive UI
- Animated gradient background
- Cursor-following glow
- Theme toggle
- Dashboard

ACCOUNT RULES
-------------
1. Employees DO NOT have system accounts.
2. Admin can create additional Inventory Staff accounts.
3. Inventory Staff cannot create system accounts.
4. The Admin account is protected from deactivation in the UI.

XAMPP SETUP
-----------
1. Put this folder in:
   C:\xampp\htdocs\property-custodian-system

2. Start Apache and MySQL in XAMPP.

3. Open phpMyAdmin:
   http://localhost/phpmyadmin

4. Import database.sql.

5. Open:
   http://localhost/property-custodian-system/setup.php

6. After setup succeeds, DELETE setup.php.

7. Login:
   Admin:
   username: admin
   password: admin123

   Inventory Staff:
   username: inventory
   password: inventory123

IMPORTANT
---------
Change the demo passwords after installation.
