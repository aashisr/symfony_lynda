Modeling Magazines in the Database
==================================

Generating Models/Entities using command line
------------------------------------
Let's generate models now using the Symfony command line tool.

Switch to a terminal. Make sure you're in the Symfony root folder. Looks like I'm already there. We're going to be using the php app/console with a doctrine generate entity. Let's see the help options first, --help. Like other Symfony commands there's comprehensive documentation that describes how to use the command. Let's generate the publication entity first. I'm just going to type up and delete help to start the command. The entity shortcut name has a specific format.

The complete name in the bundle followed by a colon and the name of the entity. In this case, it's LyndaMagazineBundle, notice that it autocompletes, :Publication. The configuration format should be the same as what we used for the bundle generation which is annotation. This will use comments for the configuration and we'll be reviewing that shortly. Press enter to accept. The next step is to add fields which is going to be kind of a wizard loop that will walk us through entering each field. The id field is added automatically so we won't need to specify.

For a publication there's only one remaining field, the name. For the field type, this can be slightly confusing. String is limited, like a varchar and text is unlimited. Let's use string which is the default, as we don't want infinite length publication names. As we chose a field type with a configuration option. We're going to be asked for a maximum length. 255 is a logical default. We don't need to add any other fields to a publication so press enter to stop the wizard. The next question is about empty repository classes which are designated for inheritance and can contain methods with query logic.

It's best practice to create it for isolation, test, and reuse. So say yes. That was the last question we're asked to confirm. If it looks good, say yes. The entities been generated. In some ways that was kind of anticlimactic. We're going to analyze what was created shortly but for the time being, let's create the issue entity as well. So just press up to repeat the last command. This will be a LyndaMagazineBundle:issue annotation for the configuration format and we're now back to the field creation wizard.

This one will be a bit more comprehensive. We actually don't need to specify a foreign key for the publication. We're going to be doing that later. Instead let's start with the issue number. We're going to be storing the number as an integer. We'll also need the date of the publication and it's best stored as a date. Notice that autocompletion occurs but I don't want this to be a date time so just press backspace and it will just say date. Press enter and that will be that. The final field is a cover. The cover should be stored as a string and our pathnames won't be that long, so 255 will be fine.

That's it for fields. So just press enter again to complete the field wizard. Do we want to generate the empty repository class? Yes we do. Review it, if it looks good, say yes. The two entities have been generated. There my jobs done, let's go home. Wait, you actually want to use and customize it? Well, since you asked so nicely. Let's take a look at what we created.

Customizing and generating databse tables
------------------------------------------
Let's take a quick look at what we've created in our IDE. Within the magazine bundle folder, there's a new folder called entity. This contains four files, issue and publication, along with their associated repositories. Let's take a look at a publication repository. As I mentioned before, this is kind of an empty place holder. Nothing particularly interesting, and it has no functional impact at this time. Let's close the file. Open instead, the publication entity itself. Note right at the top, the name space, Lynda, the vendor name, followed by the name of the bundle, magazine bundle, and finally, entity, which is the type of model that Doctrine manages.

Underneath, Foctrine's mapping name space is imported as ORM. The publication class itself is deceptively simple looking. Again, annotation comments are used for the configuration. The first line, publication, is just the name of the class. However, the ORM table annotation indicates that a table named publication will be created by default. I personally dislike table names that are singular with capital letters, and consider it a best practice to name them in lowercase plural form.

To do that, we'll need to make a small change, and explicitly specify the name of the table. So within table we're going to type name equals double quotes publications. Close out the quote and save the file. Underneath, the entity explicitly declares the existence of the empty repository class, so if we ever added anything to it, Doctrine would know how to use it. The publication class has only two properties, ID and name. Doctrine doesn't care if the properties are private or protected.

The default is private. The column notation describes the name and type of field. The ORM ID annotation is special in that it describes that the column will be a primary key. Finally, the generated value, with strategy auto, results in an auto-incremented identifier. Name is a bit simpler, with only one annotation for the column. The name, the type, and length are specified. Underneath, there are two public convenience methods, a get and set for each property. These are generated and can easily be modified if needed.

Close the file and open up issue. Basically, this is the same structure as publication. We'll need to make the change to the schema by specifying the name of the table. So in table we'll type name equals double quotes and then issues, which is the name of the entity, lowercase and plural. Save the changes, then close the file. Earlier, I mentioned that we could generate the data base schema, and with those changes, we're ready to do that. First, let's make sure that the data base is empty.

I'm going to switch to my browser, open a new tab, and navigate to PHP my admin. Open up the data base in question. Currently there are no tables found in the data base. That's a good thing. We have a clean slate, which is ready for development. Let's switch over to the terminal to generate the schema. Make sure you're in the Symfony root, and type php space app slash console, then doctrine colon schema colon update. There's a built-in safety mechanism that prevents the update from actually taking place, and warns that we shouldn't be doing this in a production environment.

We're currently in a development environment with a clean database, so we can execute the command safely. Just press up to repeat the command space dash dash force to execute. Press enter, and the schema's now updated. Let's take a look at what was created by switching back to the sequel client. If I click sand box again, I can see that two tables exist now, issues and publications. Fantastic, but what about defining an association between our entities?

Establishing association between entities
-----------------------------------------

Doctrine supports many kinds of Association Mapping for it to finding relationships between entities. There are three main kinds of associations. The first is one to one, where each row is linked to one, and only one row. The next kind, one to many, is very common where each row can be related with many rows in another table. We're going to be using a one to many association with publication as the one parent and issue as the many children. Finally, Doctrine supports many to many associations where one or more rows can be related to zero, one, or more rows in another table.

Within these associations, there are variants like supporting a joining table and so forth. Actually describing these associations between entities takes a number of steps so I'm going to describe them in detail. Then we'll do it together. In the parent, three major steps are required. First, we'll need to add a property to the entity to store the child's associations. It's best practice to give the property a plural name based on the child. Doctrine uses a data structure called collections to represent the association with entities.

One of the most common is the ArrayCollection which wraps a regular PHP array and allows a developer to interact with it just like it was a regular array. We'll also need to add an annotation for configuring the property. Specifying a one to many, with two properties. The target entity, which is the child's entity name then mapped by, which will be the property name in the child's that will store the parent association. Finally, we'll need a constructor to populate the property that contains the association.

This parts really simple. All we need is an empty ArrayCollection. On the other side, we'll need to add a property to the child to hold the association with the parent. The best practice here is to name it the singular name of the parent. While we don't need a constructor, two annotations for the property will be required. The first, many to one, defines the inverse association with a target entity as the parent entity name and inversed by to describe the name of the property within the parent for the children association.

Additionally, the foreign key association needs to described with a join column. This contains the name of the CHILDFOREIGNKEY then the referencedColumnName which is the PARENTPRIMARYKEY. I'll admit, this might sound a bit confusing but with a practical example it should make a lot more sense. Once the parent and child associations have been specified we'll need to perform updates to take account for the structural changes. First, we'll need to update the schema by running the doctrine schema update command again, which adds the foreign key association to the database.

Then we'll update the entities themselves using the generate entities command. Practically speaking, this just generates the helper methods for adding and removing children. Don't worry about overwriting your own code. Generate entities is safe to use and will not overwrite existing methods and will even make backups as well. Now that we've got a high level understanding of what we need to do let's actually make the changes to our application. Switch over to the IDA. Navigate to and open publication entity. We're going to start off by importing the doctrine common collections array collection.

Within the class publication we're going to add a private property called issues. To contain the issues, named after the plural of the children. Let's add a DocBlock to it with a type ArrayCollection, remove the extra line at top, add a couple spaces and then let's start a new annotation for ORM slash and define the one to many association. So one to many, new parentheses target entity equals double quote issue with a capital "I" for the name of the model comma mapped by equals in double quotes publication.

Which is the name of the target property. Close out the parentheses and that's all we need. Finally we'll need to define a constructor. So underneath the last property, public function underscore underscore construct. We're going to initialize this issues equals new ArrayCollection. That's all that's needed in the parent. Save publication, close it out and open the issue entity. Write at the top of the issue, add a new line and use doctrine common collections ArrayCollection.

Similar to publication, let's add a new private property. Private, to contain the parent publication publication. Add a DocBlock and for the type it's just publication. Remove the extra line, go down. We'll add an annotation for a ORM for the many to one association so a target entity equals double quotes publication close the double quote inversed by equals and in lower case issues.

We'll also need to add an annotation for the join column. So join column parentheses name equals in the child's table, the column is named publication underscore id and the referenced column name equals just id which is the foreign key within publications. Remember we didn't explicitly create publication id using the wizard but this will create it. Once complete save the issue entity and then close it.

We're going to need to switch back to the terminal for the final steps. Let's take a look at what the schema changes are going to do before we actually perform them. One of the options for the PHP app console doctrine schema update command is dash dash dump dash sql which will display the sequel that will be used. Three statements, the first will add the column for publication id another adds the foreign key relation and finally an index is added to issues on publication id.

When we're ready we can apply the update the same way that we created the schema by forcing it. That's to type PHP app console doctrine schema update space dash dash force. The last step is to generate the changes to the entities. This is a slightly different command then before. Entities will update multiple entities and will take the vendor name as an argument. So I'm going to use PHP app slash console doctrine generate entities and then just the name of Lynda.

Every single entity below the Lynda vendor will be updated and backups created. What did we create? Switch back to the IDA. In the publication entity, we scroll down, there are now helpers to add, remove, and get issues. If we look back at add issues, the method is using regular array notation. However, remove issue uses the remove element method which is part of doctrine's ArrayCollection. Close publication, then open issue. Scroll down to the bottom and you notice that there's just a get and a set for the publication method.

Note that there is not a helper to get or set the publication id even though the column exists in the database. Close out the issue entity. Now that we've got our model set up let's actually use them within a controller.


Generating Controllers
------------------------
In addition to schemas and updating entities, doctrine can also generate controllers based on the structure of entities, If it doesn't already exist, doctrine will create a controller class in the right place within the bundle. That part is fairly trivial, but the creation of actions that map to the basic CRUD interactions, like "create", "read", "update", and "destroy", is very useful and provides a great starting place. Of course, routes are generated as well which describes how users can access each action. Basic forms are included for the interactive actions that require user input, and we'll explore those in a later chapter.

Finally, templates in a Twig format will be included for rendering the actual output. While the end result isn't exactly something you'd want to consider finished, it's a great starting place. Let's explore the actions in a bit more detail. The generated actions are in two groups, the default, "read-only" actions which are "index", to list all the members of an entity class, and "show", which will display the contents of a particular entity instance. The second group are the "write" actions, which are a bit more comprehensive.

Starting with "new", which shows the creation form, then the "create" action itself, which will create a new entity for the form user input. "Edit", as you can imagine, displays an editing form which is used in conjunction with "update", which actually makes the changes to the entity. Finally, "delete" will delete the entity. Note that these actions are atomic as possible. Forms are handled separately from the actual interaction from the editing. Let's generate controllers for our two entities by switching to the terminal. The "PHP app/console", "generate", "doctrine", "CRUD" will generate the controllers.

Let's take a quick look at the "help" first. So, "space", "dash-dash", "help". That's some actually fairly comprehensive documentation, and even details how the generated files use a template and how to override that template. Let's generate a controller for publications. So, type, "up", and "delete", the "help", and press "enter". The first question is to give the editing shortcut name for the editing question, and an example is given. We're going to specify the "Linda magazine bundle: publication".

By default, only the "read-only" actions are provided, "list" and "show". The "write" actions are optional, but let's include them, so type, "yes". Similar to entities, let's continue to use the annotation configuration format. The routes prefix defines the route path under which the actions can be accessed under. "/publication" is logical, so let's keep that. That's the last question. Let's verify that we're gonna create a full CRUD controller using the annotation format. Yes, "I'm sure". It's all done.

The controller, actions, forms, and templates have been created, even though it's all described as just "CRUD" and "form". Let's create the issue controller while we're at it. So, press, "up", and press "enter" again to repeat the same command. This time, we'll specify the "Linda magazine bundle: issue". Yes, we'd like to generate the "write" actions, annotation, and the route's prefix looks fine. "Confirm generation?" Yes. I like this positive call to action.



Interacting with Entity Manager
-------------------------------

Doctrine provides both the models and the work of persisting data, or practically speaking, what interface do we use? Doctrine's Entity Manager is the answer, which handles the persistence of entities, including the storage and retrieval of records within the database. Within the controller, the entity manager is accessed via a shortcut to the Doctrine service. It's easy to just assign it into a variable like em equals this for the controller, get Doctrine for the Doctrine registry service, then get manager to get the Entity Manager.

The Entity Manager itself has a number of common methods. Persist which takes an argument of an entity object makes an entity instance managed by Doctrine em persist in the database. Basically, it's telling Doctrine that changes will occur. It's also possible to remove an entity as well, which will mark it as ready to be deleted. Both persist and remove must prepare with flush which will actually execute the queries against the database. Practically speaking, flush synchronizes changes between the memory and the database.

The Entity Manager doesn't directly get entities. Instead, Doctrine provides repositories which does the work of fetching entities of a certain class. The resulting entities can be persisted through the Entity Manager if there's a need to make changes. Within the controller, repositories can be accessed through the Entity Manager using the get repository method which takes an argument containing the string naming the bundle and entity. This is the same format we used when generating the controller, and that's no coincidence.

Repositories have a number of commonly used methods as well such as find which takes an ID to get an entity of a certain class by ID and find all which gets all entities of that class. Now that we've got some contacts about how we can interact with Doctrine, let's take a look at the generated controllers to see how they work. Switch to the IDE. Within source, open up the controller folder. There are two new files in here. The issue controller and the publication controller.

Let's take a look at publication. At the top of the file, the name space is declared. A Lynda magazine bundle controller. Same as the default controller. The imports are similar as well except towards the bottom. The publication entity which we created earlier and the form for the publication type. Now, that's new. We're going to be exploring forms the next chapter so let's skip it for now. Moving down, the index action is our first exposure to Doctrine. The route slash publication maps to what we saw in the browser.

There's actually three statements in here. The first assigns em to an instance of the Entity Manager. The second statement assigns the variable entities to a change command, getting the repositories for the publication within the Lynda magazine bundle, then find all to the publication entities. The third and last statement sends data view template. One key entities containing, well, the entities. Wait, that's it? Yup, this is an extremely thin controller. Let's take a look at the associated template.

Open resources to get the views. There are two new folders here. Issue and publication and each is named after the controller. Within publication, there are four templates. Edit, index, new, and show. Let's take a peek at index. We're going to learn a lot more about Twig templates after we dive in the forms but honestly, this is pretty much straight HTML with a little additional markup. There's a header the says publication list that a table that loops through entities.

The first cell prints the path to publication show. The next cell prints the name of the entity. There are links to show and edit. That's it for the for loop. At the bottom, there's a link to create a new entry. This is complete separation of design and logic. Close the index template. Back in the publication controller, let's take a look at create action. We have that there's a different method post, and that a template is explicitly defined using the bundle name, entity name, then the name of the file.

The method takes an argument of an instance of request as we need access to use our import. The method itself starts of the new entity of type publication, then a form. We'll be covering forms in just a moment. But just reading through it, a new form is creating with the structure of an entity. On the next line, the form receives the request, the user input. If the form validates, then the Entity Managers retrieve, the entity is persistent and flushed. When complete, a redirection takes place which will redirect the browser to a new location which is publication show with the ID of the newly persisted entity.

Otherwise, both the entity and form are sent to the view. For comparison, let's look at the show action. The route puts ID in brackets, which if we look at the show action argument, is the same name and is populated by whatever the user specifies in the path. Within the method, again the Entity Manager is instantiated. Then on the next line, an entity is populated using the find method. But the entity isn't found, an exception is thrown. Otherwise, both the entity and the delete form are sent to the view. In this chapter, we've been exploring how to model magazines in the database.

We introduced both Doctrine and object-relational mapping, including features and comparisons to propel. Then we modeled a magazine by generating an entity, then customize the newly created entities and generated database tables for persistence storage. We established one to many and many to one associations between entities. With that foundation, we used Doctrine to generate the magazine controllers, both publication and issue. Other than controllers, we created, edited, and debugged issues with entities, including discovering the debugged toolbar.

Finally, we interacted with Doctrine's Entity Manager and repositories, along with common methods such as persist and flush. Towards the end of this chapter, we've been seeing a lot of examples of the use of forms. How do we actually use them and customize them to our needs?
