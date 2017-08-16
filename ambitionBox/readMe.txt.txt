NOTE: 	MVC Architecture is used here so terms models, controllers and views have meaning similar to that
	in MVC.
/* ------------- Directory Structure -----------------*/
/models			contains php files that contains model class
/configurations		contains configuration files like database credentials etc.
/controllers		contains control class and also interface classes
			controller Classes 	 - "Manager" or "cleaner" as part of their Name
			interface Classes/scripts- all other files except controller classes 
/js			contains javascript files used with client side (views) scripts
/css			contains the required css files by all client side scripts
/images			contains all the images used in site
/			all other files in root directory are used for user interface (views) 

/*----------------------------------------------------*/
/*----------------Naming Conventions------------------*/
Note: 	Naming conventions followed are similar to those followed in java
1. all Classes name begins with a UpperCase letter.
2. UpperCase letter is used to seperate Word in any identifier e.g friendsManager
	similar to java.
3. all file names are in lowercase letters however for seperating words UpperCase letter is 
	used as in case of identifiers.
4. constants are represented through all uppercase letters.
5. same rules apply for methods as for identifiers.
/*----------------------------------------------------*/
/*-----------------Database Structure-----------------*/
Note:	database used here is mysql
	and file socialmessaging.sql contains the structure of tables used
Table		Description
----------------------------------------------------------------------------------------------------------------------
members		used for storing details of all member 	(includes username,password and a unique Id )
posts		used for storing posts made by members 	(includes userid, descrption and time of post)
friends		used for storing friends relation	(includes usedId1,UserId2)
request		used for storing requests made by users	(includes requesterId,requestedId, time and status of request)	
*/