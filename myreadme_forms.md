Defining and Validating Forms
==============================

Introducing Form Component
--------------------------

- One of the most common tasks in web development is creating and using HTML forms to accept user input. However, it's notoriously hard to make forms quickly, securely and reusable. Fortunately, Symfony2 comes with a Form component which solves many of these problems and allows developers to focus on writing custom business logic. We'll start our exploration with how forms are defined and how they interact with other Symfony components like Doctrine. We'll take that foundation and use it to analyze and extend the forms generated in the previous chapter.

Of course, no form would be complete without the ability to validate user input. At the end, we'll even upload files, like cover images for magazines. So, what is the Symfony2 Form component? Well, as you can probably imagine, it's a component that provides comprehensive tools for defining and using HTML forms. Like other Symfony components, the Form component is a standalone library that can be used independently of Symfony. But, at the same time, it makes a lot of sense to just use the Form component within the Symfony framework.

Beyond just adding fields to a form, the Form component handles user requests, both to populate the form and even to map request data to associated models for easy persistence. Of course, validation of user input is included, as well, providing both logical default and extensible interface for specifying as strict or as lenient rules as needed. Finally, the Form component interacts with other Symfony components, including support for Entities and even Doctrine, and the view layer through the templating component.

The Symfony Form component includes support for all regular HTML form elements and common data structures in standard field types. For example, text field types include a text and textarea, but also more specialized validation, like email addresses or urls, or a custom display for passwords. Choice fields can be used to render as choice, select, radio and check boxes, but can go further by supporting associated entities and presenting them as a choosable list or a common domain, such as country, language, and timezone.

There's also a base field type for Form, as well, which may seem a bit odd and self-referential. But there's a logic to it. With a form base field, a developer can create a reusable form, or just a fragment of a form that can either be used on its own or integrated within another form for modularity. It's considered a best practice to create reusable forms, as it helps keep operations atomic, or as small as possible. All right, so how does one actually create a form? The form builder performs the actual work of building the form.

A developer starts by initializing the form builder with an entity, then adds each form field by name. The type of field can be specified, but the default behavior is to guess the type based on the entity, which is very convenient. Finally, the form object is retrieved and used for further manipulation, or is passed to other structures. Forms have a number of common methods that we'll be using to accept user input. The first, most logical, is add, which takes the field name and an optional type in order to add a field to a form.

User input is accepted using handleRequest, which takes a standard request object. This is the Form component's equivalent of a form submission. Once data is in a form, isValid can be used to return a Boolean true or false to determine whether the form contents are valid. Unless explicitly specified, validation can use Doctrine to define defaults based on the editing, such as maximum length or whether or not a field is required. Of course, manual validation can be performed using built-in validators or creating a custom validator.

Finally, the form itself can be rendered in the view layer using the method createView, which will create a view object that is sent for rendering within a template. Symfony's controller class provides a helper method for creating forms called createForm, which is accessed through this, and takes an instance of a previously-created form class, an entity to populate, and an array of options containing values, like the action and the HETP method, like get or post. By defining a new form type class, the form can be reused and defined separately and atomically, and therefore, the use of the createForm method is preferred over just building a form in line and controlling.

All right, that's enough theory. Let's see how a publication form is defined. Within the IDE, let's take a new look at createAction. The form variable is set with a return value of create createForm, which, in turn, takes a publication. All right, let's take a look at create createForm. Right click. Navigate. Go to Declaration. Method create createForm instantiates a form using createForm, passing the entity to populate it, then options, containing the action url and the method post.

Once the form is created, the add method is used to create a submit button of field type "submit," which is pretty self-explanatory. And the label says "create." At the end, the form is returned. This keeps the createAction clean and only focuses on the business logic, and not the work of actually creating the form. What's the form definition contain? Underneath the Magazine Bundle, open up Form. You can see that there's two files here: issue type and publication type. Remember how I said form was a field type? The type suffix is as an artifact of that.

Open publication type. the name space is Lynda magazine bundle, and form, which uses a similar format to the other name spaces that we've seen. There are three imports: the abstract type, which is the base field type that any custom fields types use as a basis, the form builder interface, and an options resolver? What's that? Well, we'll see in a moment. The class publication type extends the abstract type and implements three methods. The first, build form, gets a form builder interface, for the controller helper, along with the options that were passed, such as the action and method.

There's only one function statement here, adding the form element "name." To be fair, there's only one field. Underneath, set default options loads data from an entity and puts it into the form. The resolver does the work of mapping values from an entity, which, in this case, is the publication entity. Finally, getName is used when rendering the form itelf to give a form ID and a CSS class. Phew! It might seem like a lot, but remember, this was all generated by Symfony based on the structures we defined.

What does this look like from the user side, and how can we debug it?


Displaying and Debugging a Form
--------------------------------

- Let's switch over to a browser to take a closer look at what's going on behind the scenes on a form. Let's go back to publication/new and we see a familiar form. However, let's look deeper. I'm using Google Chrome on a Mac, so I'm going to press shift-command-c to enter the inspect mode. On Windows, it's shift-control-c. Hover over the name and click, and go back up to the form. There's a couple things going on here: For one, the form name is Lynda magazine bundle publication, as well as the div ID.

That's the same form ID that was specified by getname in the publication type class. There is also a hidden input with an ID with the name of the form, __token. The value on your end is going to be a bit different than what I'm seeing. This is a cross-site request forgery token, which is generated automatically for you by default. It can optionally be customized. Very handy. Close the inspect window by clicking the X in the upper right hand corner. Remember Symfony's debug bar from earlier? Well, it's still here and it's got some debugging information for us.

The clipboard with what looks like a paper form has a number next to it. Click on it now. This will provide a debugging perspective into the form describing the model, submitted data, past options, and more. Click back to go back to the form, and let's submit a value. For the name of the publication, specify gravel gatherer, and click create. The publication is created, but let's check the debug form by clicking the icon again. Odd, the form wasn't submitted. Well, actually, that's technically accurate because it's redirecting upon completion.

So, go up, and click view last 10. See that post? Click the token next to it. Ah, that's a lot better. The request post parameters contain the gravel gatherer as we'd expect. Up on the top, the gear shows the HTTP status along with the controller name, the action name, and the route - something to keep in mind when debugging. Let's go back to the IDE to take a closer look at how the form is rendered. Over in resources, open up views, publication, and new.html.twig.

The form is rendered with just, well, form(form). That's it. Wait, really? Alright, let's take a look at the action. Open publication, controller, and navigate to create action. So in the return value, form is set to form, create view. The create view method within the form object creates a special form view object that the template can use to render the form. The result is actually rendered by a form helper using the syntax that we just saw, form(form).

However, many designers want a bit more control than that, and that's where form templates come in. For example, the form can be started, errors displayed, maybe in a div with a different class, then the row with the name element as displayed, and then the form is closed out. Even more granularity is possible, down to the widget with form theming. Okay, so we've got a sense of how a form is built and displayed, but what about adding validators for input?

Validating Data with Constraints
----------------------------------

-The Symfony Validation component is used to validate data and forms. A key concept in Symfony Validation is constraints, which are a list of rules for an object that are used to determine the validity of the data. Each rule is an assertion that is added to the entity itself. For example, an assertion can state a property must not be blank, and have a numeric range of, say one to 50. Even though we're working with forms, the validation itself takes place on the object, not the form. When asking a form to validate itself, the end result is actually a shortcut that asks the entity to validate.

If the entity passes, then the form validates. Constraints can have numerous targets. Properties is the most obvious place, and that's the most common and easy to use constraint. For example, a property constraint on a property storing an area code in the United States would require that the contents be exactly three numeric digits. Similar to properties are getters, which are the methods that start with get or has, like the ones generated with entity. Getter targets are useful for cross-property checks, like checking to see if a user set their password to their username.

Finally, constraints can be placed on classes of entities, which then can be used to validate the entire class using methods specified by the constraint. Similar to many other kinds of Symfony configuration, assertions can be defined in a variety of ways. Annotations are easy to understand, especially if the logic is defined in the same place as the rest of the code. The assertions are added to an entity by a target described earlier. When using an assertion, we'll need to import the validator component constraints as assert. That way we can use the annotation notation to assert a method such as asserting that the length of a string must be at least two characters long.

Each form type has its own options for setting logical defaults, which begs the question, are form options validators? Not really, which isn't exactly as definitive as you might expect. All right, to clarify, form options are for client-side checks and logical defaults. The client-side checks are validators in a way, but that's an incomplete picture. To actually validate the data to ensure quality throughout the application, we'll still need constraints for server-side validation. Good applications use a combination of both server-side and client-side validation to improve user experience, and to make sure that only good data is stored.

Let's add some control to our forms. Switch over to the IDE. Let's open up the issue type form. Within the build form method, date publication was the field that was least logical to use. We could choose years in the future. Instead, let's explicitly define some form options that will make it easier to use. Add another argument to explicitly specify the field type, date. Then start an array. We're going to specify the years, which just takes an array of years.

I'm going to use the range PHP function to take a date of the current year, and then date of year comma string to time minus 50 years. Might not be the perfect default for every collector, but it's a starting place. Let's also make sure that this form element is required by adding required to boolean true. On the next line, we're not quite ready to deal with cover yet, so let's just comment it out. While we're at it, let's make publication required.

Publication is an entity, so we're going to have to specify entity as the field type, and then add an array of options. The first option is required, which we'll set to true. While it may be tempting to stop, these options override the guest option, so right now there's no way for the field to know what the source data is. We'll need to explicitly specify it with a class, which is linda magazine bundle colon publication, save the changes, and close the issue type form.

Now that we've updated the field options, let's add a validator to the issue entity. So we'll open the issue dot PHP. We'll also need to remember to use Symfony component validators constraints as assert. Scroll down to private number under the ORM annotation, add a new line, N at assert slash range. The range takes some parameters. The first is minimum, which uses the key min and the value one.

No issue number zero for this system. Different assertions also have different options, but typically there's a customizable message for each option. For example, we can specify a min message in double quotes. You'll need to specify issue one or higher. Make sure there's a closing parentheses, and save the issue entity. Let's see these changes in action. Switch over to a browser. Navigate to issue new. Ok, this is starting to look a little better.

Number actually has the ability to specify number using a select list. Let's specify negative one. For the data publication, specify 2010, August and 20. For publication notice there's only two options here, Sandy Shore and Gravel Gatherer. The empty option is no longer available. Click create. Well, we failed validation, but we expected that. All right fine, issue number one it is. Click create. Wow, that was a spectacular failure.

Integrity constraint failure? Well, it looks like the cover is required in the data base. What if we don't have a cover image? We're going to have to allow for empty covers. Back to the IDE. With an issue, scroll down to cover. In the ORM column, add a comma after the length, and add nullible equals true. This will allow empty values in the data base. Save, then go to the terminal. Update the schema by typing PHP app slash console doctrine schema update space dash dash force.

Ok, the query was executed, let's go back to the browser, and refresh, and confirm the form re-submission. Success, the issue's been created. Looks kind of barren without a cover though. Should we upload one? Of course.

Uploading Files
------------------
Well, if you feel like there hasn't been enough coding in this course, buckle up. Things are about to get real. One of the helpful parts of HTTP foundation is uploaded file which represents a file uploaded through a form. We're going to be using uploaded file in the issue entity to facilitate cover uploads. Uploaded file comes with a number of helper methods including move which takes a target directory and optional name for file. Move, as you probably guessed, moves a file to a new location. We'll also be using get client original name to get the original file name of the uploaded file.

Depending on your security or organizational needs, it may makes sense to generate a file name instead. We're going to be making a number of changes necessary for uploading a file but individually they're actually quiet straightforward. Let's walk through them first to the high level. We'll start with the issue entity and add methods to get passed to our upload directories while the absolute path on disk and the relative path for web operations. We'll also add a non-persistent field for uploading a file which are upload method for moving the uploaded file and setting the actual cover value we'll use.

Then, we'll make a small tweak to the issue controller to the create action and update action methods to perform the upload method on the entity after the form validates. Finally, we'll update the issue type form itself by adding a field for uploading a file. Let's do this. Switch to an IDE. We'll start by opening up the issue entity. At the top, we'll need to use the symphony component HTTP foundation file, uploaded file, then scroll to the bottom of the file.

We're going to add a number of helper methods. First, we'll need to define the path to the upload directory. We'll make a protected function called get upload path. Takes no arguments. Return just the relative path of uploads slash covers. Remember to add documentation, so get web path to upload directory. Return the string which is just the relative path. Then, based on the web path, let's create a helper for the absolute path.

Protected function get upload absolute path. Here's one of symphony's local gadgets. There's no one way to define where the web path is, as it's potentially so flexible. We can hard code something in the kernel or we can just take the easy out and just specify a relative path which will work just fine. Return, underscore, underscore, DIR, space, dot, slash, dot, dot, dot, dot, dot, dot, dot, dot. For total, slash web, and slash, and then can cut it, this, get uploaded path.

Once again, add documentation. This time, it will be get absolute path to upload directory. It will also return a string absolute path. With those helpers, let's make it easy to render. We'll add a public function, get cover web. Let's return and use internally function. Null, triple equals, this, get cover. Basically if there's no cover, return, null, alts, this, get upload path, cut it, with slash, and then this, get cover.

Add some documentation. Get web path to a cover, and it's going to return either null or string and relative path. Let's do the same to the path on disk with the same kind of logic. Public function get cover absolute. We can cheat a little bit. Copy and paste, and make the change. If it said get upload path, get upload absolute path, get cover.

Copy the documentation as well, and this is get path on disk to a cover. I'll also update the comment, true say absolute path. Now that we have the helper methods, let's add a temporary field for the file upload. Private, cover sign file. Let's add some validation. We're going to assert, file is going to be max size. This is the max size and bytes. Let's do it just a rough approximation of one million. One million, then some more helpers.

I'm going to enforce the expectation that this will be used with an uploaded file class. Otherwise, default to null. Public function set file, which you'll expect in uploaded file, hold file, and default to null, and this file equals file. Remember to include documentation. Set file. Then every set needs a get. Public function get file, no arguments, then return this file.

Good documentation leads to happiness. So to say, get file and return an uploaded file. Finally, we can start with an upload method. Public function upload. Of course, if there's no file, don't do anything. If I have a comment, it will say file property can be empty if no triple equals, this, get file, return. Alright, so we've passed that. We've got a file. Let's determine what the original file name is.

File name, equals, this, get file, get client original name. We're going to want to move the uploaded file to the target directory using the original name. This, get file, move, it takes two arguments, this, get upload absolute path, comma, and the file name. Then set the cover, this, set cover, and set that to the file name, then clean up.

Clean up, this, set file to nothing. Then add some documentation. Upload a cover file. That's all the changes that are needed for the issue entity. Save, then close. Open up the issue controller. Scroll down to the create action. Then after the form is valid checked, add a line to actually invoke the entity upload method. If form is valid, entity upload. Save, then go down to the upload action.

Once again, if the edit form is valid, entity upload. Save the issue controller because that's how we need here. One final step, we need to update the form itself. Close the controller, then open up the issue type form. Remove the comments from cover. Instead, you use file as the field name. Save the issue type form and close it out. Let's see our file upload in action. Switch to a browser.

Let's go back to the list, and then create a new entry. This will be issue number two for February 1st, 2013. For file, there's now a choose file element. Click on it. I've stored the exercise files on the desktop. In exercise files, assets, and let's select sandy shore file two. Click open, then create. Well, the cover says the file name. That's a good sign.

What about the uploaded file? Switch back to the IDE. Navigating over the web, there's a new directory here. Uploads, covers, and the file sandy shore 2013 underscore 02 dot JPEG. Fantastic! In this chapter, we introduced the form component starting with ways to build the form and define them as a class. We then discovered to how a form is displayed within a view template and walk through the steps for debugging a form. Because users are to be trusted, we validated form data by adding constraints to our entity.

Then finally, uploaded files containing our cover images. We're getting close to functional completion. But right now, I'll have to admit that the result isn't much to look at. In the next chapter, we're going to focus on the looking field of the application by customizing the templates in the view layer.