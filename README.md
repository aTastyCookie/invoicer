Deskmine
==========

**Demo:** [http://deskmine.ru](http://deskmine.ru)

Install:
1) Create an empty database for Deskmine on your web or database server.
2) Modify app/config/database.php to configure the appropriate database for Deskmine to use.
3) Modify app/config/app.php and change the following line to the address of your FusionInvoice install, using the appropriate domain name and subfolder, if applicable:
 `   'url' => 'http://localhost',`
4) Make sure the following folders and contents are writable:
`/app/storage
/uploads`
5) Run the FusionInvoice install/upgrade script in your browser by accessing `http://yourserver.com/setup` or `http://yourserver.com/thefolder/setup` and follow the rest of the installation process.
